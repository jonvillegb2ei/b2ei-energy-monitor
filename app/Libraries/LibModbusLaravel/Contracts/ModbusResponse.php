<?php


namespace App\Libraries\LibModbusLaravel\Contracts;



Interface ModbusResponse
{

    /**
     * @return bool
     */
    public function success(): bool;

    /**
     * @return bool
     */
    public function error(): bool;

    /**
     * @return string
     */
    public function getRequest(): string;

    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @return ModbusDataCollection
     */
    public function getData() : ModbusDataCollection;

    /**
     * @return bool
     */
    public function hasException() : bool;

    /**
     * @return \Exception
     */
    public function getException() : \Exception;


}