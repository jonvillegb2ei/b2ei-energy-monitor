<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class ConnectionWriteError extends BaseException
{

    public $fatal = true;
    protected $message = "The connexion in writing mode to fail";
    protected $code = 15;
}

