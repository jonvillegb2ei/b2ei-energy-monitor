<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 20/02/2018
 * Time: 16:10
 */

namespace App\Libraries\LibModbusLaravel;

use App\Libraries\LibModbusLaravel\Contracts\ModbusResponse as ModbusResponseInterface;
use App\Libraries\LibModbusLaravel\Contracts\ModbusDataCollection as ModbusDataCollectionInterface;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\IllegalFunction;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\IllegalDataAddress;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\IllegalDataValue;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\SlaveDeviceFailure;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\AcknowledgeError;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\SlaveDeviceBusy;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\NegativeAcknowledge;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\MemoryParityError;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\GatewayPathUnavailable;
use App\Libraries\LibModbusLaravel\Exceptions\Modbus\GatewayTargetDeviceFailedToRespond;




class ModbusResponse implements ModbusResponseInterface
{

    /**
     * @var bool Response success status
     */
    protected $status;

    /**
     * @var ?\Exception Response success status
     */
    protected $exception = null;

    /**
     * @var int Response code
     */
    protected $code;


    /**
     * @var ModbusDataCollection Response data collection
     */
    protected $data;


    /**
     * @var int Response slave identifier
     */
    protected $slave;


    /**
     * @var int Response the request as string representation
     */
    protected $request;

    protected $function_code = null;

    protected $footer = null;


    /**
     * @var int Response the request as string representation
     */
    protected $header;


    /**
     * @param ModbusClient $client
     * @param int $header_length
     * @param int $footer_length
     * @return $this
     * @throws \Exception
     */
    static public function fromClient(ModbusClient $client, int $header_length = 0, int $footer_length = 0): ModbusResponseInterface
    {
        $header = $header_length > 0 ? $client->client_read($header_length) : '';

        if ($header_length>0) {
            $exception = $client->checkHeader($header);
            if ($exception instanceof \Exception) {
                throw $exception;
            }
        }

        $slave = ord($client->client_read(1));
        $code = ord($client->client_read(1));
        $quantity = ord($client->client_read(1));
        $exception = null;
        if (($code & 0b10000000) > 0) {
            $subCode = $quantity;
            if ($subCode === 0x01)
                $exception = new IllegalFunction();
            else if ($subCode === 0x02)
                $exception = new IllegalDataAddress();
            else if ($subCode === 0x03)
                $exception = new IllegalDataValue();
            else if ($subCode === 0x04)
                $exception = new SlaveDeviceFailure();
            else if ($subCode === 0x05)
                $exception = new AcknowledgeError();
            else if ($subCode === 0x06)
                $exception = new SlaveDeviceBusy();
            else if ($subCode === 0x07)
                $exception = new NegativeAcknowledge();
            else if ($subCode === 0x08)
                $exception = new MemoryParityError();
            else if ($subCode === 0x0A)
                $exception = new GatewayPathUnavailable();
            else if ($subCode === 0x0B)
                $exception = new GatewayTargetDeviceFailedToRespond();
        }
        $data = $client->client_read($quantity);
        $collection = ModbusDataCollection::fromString($data);

        if ($footer_length > 0) $footer = $client->client_read($footer_length);
        else $footer = '';

        $request = chr($slave) . chr($code) . chr($quantity) . $data;

        if ($footer_length>0) {
            $exception = $client->checkFooter($footer, $request);
            if ($exception instanceof \Exception)
                throw $exception;
        }

        return (new self())
            ->setHeader($header)
            ->setFooter($footer)
            ->setRequest($request)
            ->setCode($code)
            ->setData($collection)
            ->setException($exception)
            ->setStatus(($code & 0b10000000) == 0)
            ->setSlave($slave);
    }



    /**
     * @return bool
     */
    public function success(): bool
    {
        return $this->status == true;
    }



    /**
     * @return bool
     */
    public function error(): bool
    {
        return $this->status == false;
    }



    /**
     * @return string
     */
    public function getRequest(): string
    {
        return $this->request;
    }



    /**
     * @param string $request
     * @return ModbusResponse
     */
    public function setRequest(string $request): ModbusResponse
    {
        $this->request = $request;
        return $this;
    }




    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        return $this->status;
    }



    /**
     * @param $status
     * @return ModbusResponse
     */
    public function setStatus($status): ModbusResponse
    {
        $this->status = $status;
        return $this;
    }



    /**
     * @param ModbusDataCollectionInterface $data
     * @return ModbusResponse
     */
    public function setData(ModbusDataCollectionInterface $data): ModbusResponse
    {
        $this->data = $data;
        return $this;
    }



    /**
     * @return ModbusDataCollectionInterface
     */
    public function getData(): ModbusDataCollectionInterface
    {
        return $this->data;
    }




    /**
     * @return int
     */
    public function getSlave(): int
    {
        return $this->slave;
    }



    /**
     * @param $slave
     * @return ModbusResponse
     */
    public function setSlave($slave): ModbusResponse
    {
        $this->slave = $slave;
        return $this;
    }




    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }



    /**
     * @param int $code
     * @return ModbusResponse
     */
    public function setCode(int $code): ModbusResponse
    {
        $this->code = $code;
        $error = ($this->status & 0b10000000) > 0;
        $this->setStatus(!$error);
        return $this;
    }



    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @param string $header
     * @return ModbusResponse
     */
    public function setHeader(string $header): ModbusResponse
    {
        $this->header = $header;
        return $this;
    }


    /**
     * @return string
     */
    public function getFooter(): string
    {
        return $this->footer;
    }

    /**
     * @param string $footer
     * @return ModbusResponse
     */
    public function setFooter(string $footer): ModbusResponse
    {
        $this->footer = $footer;
        return $this;
    }



    /**
     * @return mixed
     */
    public function hasException(): bool
    {
        return $this->exception instanceof \Exception;
    }


    /**
     * @return mixed
     */
    public function getException(): \Exception
    {
        return $this->exception;
    }



    /**
     * @param mixed $exception
     * @return ModbusResponse
     */
    public function setException($exception)
    {
        $this->exception = $exception;
        return $this;
    }

}