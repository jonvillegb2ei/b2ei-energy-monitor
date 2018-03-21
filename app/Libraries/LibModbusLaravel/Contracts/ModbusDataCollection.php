<?php


namespace App\Libraries\LibModbusLaravel\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Countable;
use ArrayAccess;
use Illuminate\Support\Collection;
use JsonSerializable;
use IteratorAggregate;
use Illuminate\Contracts\Support\Jsonable;

Interface ModbusDataCollection extends ArrayAccess, Arrayable, Countable, IteratorAggregate, Jsonable, JsonSerializable
{

    public function withEndianness(bool $value = true): ModbusDataCollection;

    public function readUint16(int $offset = 0):int;
    public function writeUint16(int $data, int $offset = 0):  ModbusDataCollection;

    public function readUint32(int $offset = 0):int;
    public function writeUint32(int $data, int $offset = 0): ModbusDataCollection;

    public function readInt16(int $offset = 0):int;
    public function writeInt16(int $data, int $offset = 0): ModbusDataCollection;

    public function readInt32(int $offset = 0):int;
    public function writeInt32(int $data, int $offset = 0): ModbusDataCollection;

    public function readInt64(int $offset = 0):int;
    public function writeInt64(int $data, int $offset = 0): ModbusDataCollection;

    public function asIdentifierString(): string;
    public function readString(int $offset = 0, int $length = 1): string;
    public function writeString(string $data, int $offset = 0): ModbusDataCollection;

    public function readFloat32(int $offset = 0): float;
    public function writeFloat32(float $data, int $offset = 0): ModbusDataCollection;

    public function readBitmap(int $offset = 0, int $length = 1, int $bit = null):array;


}

