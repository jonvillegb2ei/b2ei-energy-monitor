<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class InvalidCRC extends BaseException
{

    public $fatal = false;
    protected $message = "The CRC code is wrong";
    protected $code = 1;
}

