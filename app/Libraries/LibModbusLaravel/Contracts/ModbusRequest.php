<?php


namespace App\Libraries\LibModbusLaravel\Contracts;



Interface ModbusRequest
{


    public function getSlave(): int;
    public function setSlave(int $slave): ModbusRequest;

    public function getFunctionCode(): int;
    public function setFunctionCode(int $function_code): ModbusRequest;

    public function getData():string;
    public function setData( ModbusDataCollection $data): ModbusRequest;

    public function withCrc16(bool $state = true): ModbusRequest;

    public function getRequest(): string;

    public function setHeader(string $data = ''): ModbusRequest;

}

