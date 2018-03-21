<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class InvalidDataLength extends BaseException
{

    public $fatal = false;
    protected $message = "Invalid data length ";
    protected $code = 16;
}

