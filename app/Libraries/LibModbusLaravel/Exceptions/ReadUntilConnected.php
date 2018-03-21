<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class ReadUntilConnected extends BaseException
{

    public $fatal = true;
    protected $message = "Read until connected ";
    protected $code = 21;
}

