<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class CloseConnectionError extends BaseException
{


    public $fatal = false;
    protected $message = "Close Connection Error";
    protected $code = 12;
}

