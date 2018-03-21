<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class WriteUntilConnected extends BaseException
{

    public $fatal = true;
    protected $message = "write until connected  ";
    protected $code = 22;
}

