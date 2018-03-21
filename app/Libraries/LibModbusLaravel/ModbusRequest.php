<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 20/02/2018
 * Time: 15:42
 */

namespace App\Libraries\LibModbusLaravel;

use App\Libraries\LibModbusLaravel\Contracts\ModbusRequest as InterfaceModbusRequest;
use App\Libraries\LibModbusLaravel\Contracts\ModbusDataCollection as InterfaceModbusDataCollection;

use App\Libraries\LibModbusLaravel\Exceptions\InvalidSlaveIdentifier;
use App\Libraries\LibModbusLaravel\Exceptions\InvalidFunctionCode;



class ModbusRequest implements InterfaceModbusRequest
{

    private $slave = 255;

    private $function_code = null;

    private $data = null;

    private $with_crc16 = false;

    public $register;
    private $header = '';


    /**
     * @param bool $state
     * @return InterfaceModbusRequest
     */
    public function withCrc16(bool $state = true):InterfaceModbusRequest
    {
        $this->with_crc16 = $state;
        return $this;
    }

    /**
     * Return the slave identifier
     *
     * @return int
     */
    public function getSlave():  int
    {
        return  $this->slave;
    }

    /**
     * Set request slave identifier
     *
     * @param int $slave
     *
     * @return InterfaceModbusRequest
     *
     * @throws InvalidSlaveIdentifier
     *
     */
    public function setSlave(int $slave):InterfaceModbusRequest
    {
        if ($slave < 0) throw new InvalidSlaveIdentifier('Slave identifier can not be lower than 0');
        else if ($slave > 255) throw new InvalidSlaveIdentifier('Slave identifier can not be upper than 255');
        else $this->slave = $slave;
        return $this;
    }


    public function getFunctionCode():int
    {
        return $this->function_code;
    }

    /**
     * @param int $function_code
     * @return InterfaceModbusRequest
     * @throws InvalidFunctionCode
     */
    public function setFunctionCode(int $function_code):InterfaceModbusRequest
    {
        if (!in_array($function_code, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 43]))
            throw new InvalidFunctionCode('Unknown function code');
        else $this->function_code = $function_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @param InterfaceModbusDataCollection $data
     * @return ModbusRequest
     */
    public function setData(InterfaceModbusDataCollection $data):InterfaceModbusRequest
    {
        $this->data = $data;
        return $this;
    }


    /**
     * @return string
     */
    private function getCrc16():string
    {
        $crc = 0xFFFF;

        $data = [$this->slave, $this->function_code];
        foreach($this->data as $octet) $data[] = ord($octet);

        for ($i = 0; $i < count($data); $i++) {
            $crc ^= $data[$i];

            for ($j = 8; $j != 0; $j--) {
                if (($crc & 0x0001) != 0) {
                    $crc >>= 1;
                    $crc ^= 0xA001;
                } else $crc >>= 1;
            }
        }
        $highCrc = floor($crc / 256);
        $lowCrc = ($crc - $highCrc * 256);
        return chr($lowCrc) . chr($highCrc);
    }


    /**
     * @param bool $with_crc16
     * @return string
     */
    public function getRequest(bool $with_crc16 = false): string
    {
        $return = $this->header.chr($this->slave) .chr($this->function_code) .$this->data;


        if ($this->with_crc16) {
            $return .= $this->getCrc16();
        }
        return $return;
    }

    /**
     * @param string $data
     * @return InterfaceModbusRequest
     */
    public function setHeader(string $data = '') : InterfaceModbusRequest
    {
        $this->header = $data;
        return $this;
    }
}

