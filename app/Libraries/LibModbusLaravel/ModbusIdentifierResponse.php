<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 20/02/2018
 * Time: 16:10
 */

namespace App\Libraries\LibModbusLaravel;


use App\Libraries\LibModbusLaravel\Contracts\ModbusIdentifierResponse as ModbusIdentifierResponseInterface;
use App\Libraries\LibModbusLaravel\Contracts\ModbusResponse as ModbusResponseInterface;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\IllegalFunction;
use App\Libraries\LibModbusLaravel\Exceptions\NoDeviceResponse;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\IllegalDataAddress;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\IllegalDataValue;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\SlaveDeviceFailure;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\AcknowledgeError;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\SlaveDeviceBusy;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\NegativeAcknowledge;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\MemoryParityError;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\GatewayPathUnavailable;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\GatewayTargetDeviceFailedToRespond;
use App\Libraries\LibModbusLaravel\Exceptions\NoResponseData;
use Illuminate\Support\Collection;

class ModbusIdentifierResponse extends ModbusResponse implements ModbusIdentifierResponseInterface
{

    private $objects = null;

    /**
     * @param Collection $objects
     * @return $this
     */
    public function setObjects(Collection $objects)
    {
        $this->objects = $objects;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getObjects(): Collection
    {
        return $this->objects;
    }

    /**
     * @param ModbusClient $client
     * @param int $header_length
     * @param int $footer_length
     * @return ModbusResponseInterface
     * @throws AcknowledgeError
     * @throws GatewayPathUnavailable
     * @throws GatewayTargetDeviceFailedToRespond
     * @throws IllegalDataAddress
     * @throws IllegalDataValue
     * @throws IllegalFunction
     * @throws MemoryParityError
     * @throws NegativeAcknowledge
     * @throws SlaveDeviceBusy
     * @throws SlaveDeviceFailure
     * @throws \Exception
     */
    static public function fromClient(ModbusClient $client, int $header_length = 0, int $footer_length = 0): ModbusResponseInterface
    {
        $header = $header_length > 0 ? $client->client_read($header_length) : '';

        if ($header_length>0) {
            $exception = $client->checkHeader($header);
            if ($exception instanceof \Exception)
                throw $exception;
        }

        $slave = ord($client->client_read(1));
        $code = ord($client->client_read(1));
        $sub_code = ord($client->client_read(1));

        if (($code & 0b10000000) > 0) {
            if ($sub_code === 0x01)
                throw new IllegalFunction();
            else if ($sub_code === 0x02)
                throw new IllegalDataAddress();
            else if ($sub_code === 0x03)
                throw new IllegalDataValue();
            else if ($sub_code === 0x04)
                throw new SlaveDeviceFailure();
            else if ($sub_code === 0x05)
                throw new AcknowledgeError();
            else if ($sub_code === 0x06)
                throw new SlaveDeviceBusy();
            else if ($sub_code === 0x07)
                throw new NegativeAcknowledge();
            else if ($sub_code === 0x08)
                throw new MemoryParityError();
            else if ($sub_code === 0x0A)
                throw new GatewayPathUnavailable();
            else if ($sub_code === 0x0B)
                throw new GatewayTargetDeviceFailedToRespond();

        }


        $product_id = ord($client->client_read(1));
        $conformityLevel = ord($client->client_read(1));
        $reserved = $client->client_read(2);
        $object_count = ord($client->client_read(1));

        $data = '';

        $collection = collect([]);


        if($object_count == 0) {
            throw new NoResponseData();
        }


        for ($index=0;$index<$object_count;$index++) {
            $object_number = ord($client->client_read(1));
            $object_length = ord($client->client_read(1));
            $object_data = $client->client_read($object_length);
            $collection[$object_number] = ModbusDataCollection::fromString($object_data);
            $data .= chr($object_number).chr($object_length).$object_data;
        }

        if ($footer_length > 0) $footer = $client->client_read($footer_length);
        else $footer = '';
        $request = chr($slave).chr($code).chr($sub_code).chr($product_id).chr($conformityLevel).chr($reserved).chr($object_count).$data;

        if ($footer_length>0) {
            $exception = $client->checkFooter($footer, $request);
            if ($exception instanceof \Exception)
                throw $exception;
        }

        return (new ModbusIdentifierResponse())
            ->setHeader($header)
            ->setFooter($footer)
            ->setRequest($request)
            ->setCode($code)
            ->setObjects($collection)
            ->setStatus(($code & 0b10000000) == 0)
            ->setSlave($slave);
    }


}