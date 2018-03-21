<?php


namespace App\Libraries\LibModbusLaravel\Contracts;



use Illuminate\Support\Collection;

Interface ModbusIdentifierResponse extends ModbusResponse
{


    public function getObjects(): Collection;

    public function setObjects(Collection $objects);

}