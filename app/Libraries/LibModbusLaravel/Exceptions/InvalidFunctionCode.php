<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class InvalidFunctionCode extends BaseException
{

    public $fatal = false;
    protected $message = "Invalid code function";
    protected $code = 17;
}

