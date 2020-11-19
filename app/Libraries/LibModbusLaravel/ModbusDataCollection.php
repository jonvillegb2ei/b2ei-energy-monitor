<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 20/02/2018
 * Time: 15:42
 */

namespace App\Libraries\LibModbusLaravel;


use Illuminate\Support\Collection;
use App\Libraries\LibModbusLaravel\Exceptions\InvalidDataLength;
use App\Libraries\LibModbusLaravel\Contracts\ModbusDataCollection as ModbusDataCollectionInterface;
use Illuminate\Support\Facades\Log;


class ModbusDataCollection extends Collection implements ModbusDataCollectionInterface
{

    const BIT_8 = 1;
    const BIT_16 = 2;
    const BIT_32 = 4;
    const BIT_64 = 8;

    protected $endianness = true;

    private function getBytes(int $offset = 0, int $length = 1)
    {
        if ($offset > 0) $offset = (($offset-1) * 2);
        else  $offset = (($offset) * 2);
        if ($offset + $length > $this->count())
            throw new InvalidDataLength();
        return self::applyEndianness($this->slice($offset, $length)->values(), $this->endianness);
    }

    private static function applyEndianness(Collection $data, bool $endianness)
    {
        if (!$endianness) {
            for($i=0;$i<$data->count();$i+=2) {
                $tmp = $data[$i];
                $data[$i] = $data[$i + 1];
                $data[$i + 1] = $tmp;
            }
        }
        return $data;
    }

    private function combineBytes(Collection $data)
    {
        $return = 0;
        for($i=0;$i<$data->count();$i+=2) {
            $return = $return | ((0xFF & $data[$i + 1]) << (8 * ($data->count() - 1 - $i)));
            $return = $return | ((0xFF & $data[$i]) << (8 * ($data->count() - 2 - $i)));
        }
        return $return;
    }

    private function toUnsignedInt64($value)
    {
        return (0x800000000000 & $value) != 0 ? (int)(((int) (0x7FFFFFFFFFFF & $value)) + 0x800000000000) : (int) (0x7FFFFFFF & $value);
    }

    private function toSignedInt64($value)
    {
        return (0x80000000 & $value) != 0 ? (int)(-(0x7FFFFFFF & ~$value)-1) : (int)(0x7FFFFFFF & $value);
    }

    private function toUnsignedInt32($value)
    {
        return (0x80000000 & $value) != 0 ? (int)(((int) (0x7FFFFFFF & $value)) + 2147483648) : (int) (0x7FFFFFFF & $value);
    }

    private function toSignedInt32($value)
    {
        return (0x80000000 & $value) != 0 ? (int)(-(0x7FFFFFFF & ~$value)-1) : (int)(0x7FFFFFFF & $value);
    }

    private function toUnsignedInt16($value)
    {
        return (0x8000 & $value) != 0 ? (int)(((int) (0x7FFF & $value)) + 32768) : (int) (0x7FFF & $value);
    }

    private function toSignedInt16($value)
    {
        return (0x8000 & $value) != 0 ? (int)(-(0x7FFF & ~$value)-1) : (int)(0x7FFF & $value);
    }


    /**
     * @param ModbusDataCollection|array $data
     * @return mixed
     */
    private function unpackExtract($data)
    {
        try {
            return $data[1];
        } catch(\Exception $error) {
            return  $data;
        }
    }


    public function readString (int $offset = 0, int $length = 1): string
    {
        return $this->getBytes($offset, $length)->map(function($byte) { return chr($byte); })->implode('');
    }

    /**
     * @param int $offset
     * @return int
     */
    public function readUint16 (int $offset = 0):int
    {
        $data = $this->getBytes($offset, self::BIT_16);
        $value = $this->combineBytes($data);
        return $this->toUnsignedInt16($value);
    }

    /**
     * @param int $offset
     * @return int
     */
    public function readUint32 (int $offset = 0):int
    {
        $data = $this->getBytes($offset, self::BIT_32);
        $value = $this->combineBytes($data);
        return $this->toUnsignedInt32($value);
    }

    /**
     * @param int $offset
     * @return int
     */
    public function readInt16 (int $offset = 0):int
    {
        $data = $this->getBytes($offset, self::BIT_16);
        $value = $this->combineBytes($data);
        return $this->toSignedInt16($value);
    }

    /**
     * @param int $offset
     * @return int
     */
    public function readInt32 (int $offset = 0):int
    {
        $data = $this->getBytes($offset, self::BIT_32);
        $value = $this->combineBytes($data);
        return $this->toSignedInt32($value);
    }

    /**
     * @param int $offset
     * @return int
     */
    public function readUint64 (int $offset = 0):int
    {
        $data = $this->getBytes($offset, self::BIT_64);
        $value = $this->combineBytes($data);
        return $this->toUnsignedInt32($value);
    }

    /**
     * @param int $offset
     * @return int
     */
    public function readInt64 (int $offset = 0):int
    {
        $data = $this->getBytes($offset, self::BIT_64);
        $value = $this->combineBytes($data);
        return $this->toSignedInt32($value);
    }



    /**
     * @param int $offset
     * @return float
     * @throws InvalidDataLength
     */
    public function readFloat32(int $offset = 0) : float
    {
        if ($offset + self::BIT_32 > $this->count())
            throw new InvalidDataLength();
        $data = $this->getBytes($offset, self::BIT_32)->map(function($byte) { return chr($byte); })->implode('');
        $return = $this->unpackExtract(unpack('f', $data));
        return is_nan($return) ? 0 : $return;
    }

    /**
     * @param int $offset
     * @param int $length
     * @param int|null $bit
     * @return array
     * @throws InvalidDataLength
     */
    public function readBitmap(int $offset = 0, int $length = 1, int $bit = null) : array
    {
        if ($offset + $length > $this->count())
            throw new InvalidDataLength();
        $return = collect([]);
        for($i=0;$i<$length;$i++) {
            $int = $this->readUint16($offset+$i);
            $return = $return->merge(collect(str_split(decbin($int)))->pad(16, "0"));
        }
        return $return->map(function($value) {
            return $value == "1";
        })->all();
    }














    /**
     * @param string $data
     * @return ModbusDataCollectionInterface
     */
    public static function fromString(string $data):ModbusDataCollectionInterface
    {
        return new self(array_map(function($char) { return ord($char); }, str_split($data)));
    }









    /**
     * @param int $length
     * @return ModbusDataCollectionInterface
     */
    private function padData(int $length = 2)
    {
        return $this->pad($length, 0);
    }

    /**
     * @param string $data
     * @param int $offset
     * @return ModbusDataCollection
     */
    private function write(string $data, int $offset = 0):ModbusDataCollection
    {
        $this->padData($offset + strlen($data));
        for($i = 0; $i < strlen($data) ; ) {
            if (isset($data[$i+1])) {
                $this[$offset + $i] = $this->endianness ? $data[$i] : $data[$i + 1];
                $this[$offset + $i + 1] = $this->endianness ? $data[$i + 1] : $data[$i];
                $i+=2;
            } else {
                $this[$offset + $i] = $data[$i];
                $i+=1;
            }
        }
        return $this;
    }



    /**
     * @param int $data
     * @param int $offset
     * @return ModbusDataCollectionInterface
     */
    public function writeUint16(int $data, int $offset = 0): ModbusDataCollectionInterface
    {
        return $this->write(pack( ($this->endianness ? 'n' : 'v') , $data), $offset);
    }


    /**
     * @param int $data
     * @param int $offset
     * @return ModbusDataCollectionInterface
     */
    public function writeUint32(int $data, int $offset = 0) :  ModbusDataCollectionInterface
    {
        return $this->write(pack( ($this->endianness ? 'N' : 'V') , $data), $offset);
    }

    /**
     * @param int $offset
     * @return int
     * @throws InvalidDataLength
     */
    public function readInt8(int $offset = 0):int
    {
        if (($offset*2) + self::BIT_8 > $this->count())
            throw new InvalidDataLength();
        $data = $this->extractWords(($offset*2),self::BIT_8);
        return   $this->unpackExtract(unpack('c', $data));
    }



    /**
     * @param int $data
     * @param int $offset
     * @return ModbusDataCollectionInterface
     */
    public function writeInt8(int $data, int $offset = 0):ModbusDataCollectionInterface
    {
        return $this->write(pack( 'C' , $data), $offset);
    }

    /**
     * @param int $data
     * @param int $offset
     * @return ModbusDataCollectionInterface
     */
    public function writeInt16(int $data, int $offset = 0):ModbusDataCollectionInterface
    {
        return $this->write(pack( 's' , $data), $offset);
    }




    /**
     * @param int $data
     * @param int $offset
     * @return ModbusDataCollectionInterface
     */
    public function writeInt32(int $data, int $offset = 0) : ModbusDataCollectionInterface
    {
        return $this->write(pack( 'l' , $data), $offset);
    }



    /**
     * @param int $data
     * @param int $offset
     * @return ModbusDataCollectionInterface
     */
    public function writeInt64(int $data, int $offset = 0) : ModbusDataCollectionInterface
    {
        return $this->write(pack( 'q' , $data), $offset);
    }



    /**
     * @param string $data
     * @param int $offset
     * @return ModbusDataCollectionInterface
     */
    public function writeString(string $data, int $offset = 0) : ModbusDataCollectionInterface
    {
        return $this->write(pack( 's', $data), $offset);
    }


    /**
     * @param float $data
     * @param int $offset
     * @return ModbusDataCollectionInterface
     */
    public function writeFloat32(float $data, int $offset = 0) : ModbusDataCollectionInterface
    {
        $data = pack( 'f' , $data);
        if (!$this->endianness)
            $data = strrev($data);
        return $this->write($data, $offset);
    }


    /**
     * @param bool $value
     * @return ModbusDataCollectionInterface
     */
    public function withEndianness(bool $value = true): ModbusDataCollectionInterface
    {
        $this->endianness = $value;
        return $this;
    }


    public function __toString()
    {
        return implode('', $this->all());
    }


    /**
     * @return string
     * @throws InvalidDataLength
     */
    public function asIdentifierString(): string
    {
        return $this->readString(0, $this->count());
    }



}

