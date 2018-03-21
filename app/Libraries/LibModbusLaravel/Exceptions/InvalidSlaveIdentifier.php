<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class InvalidSlaveIdentifier extends BaseException
{
    public $fatal = true;
    protected $message = "The slave identifier is not correct";
    protected $code = 18;

}

