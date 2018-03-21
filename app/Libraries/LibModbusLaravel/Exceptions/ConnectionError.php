<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class ConnectionError extends BaseException
{

    public $fatal = false;
    protected $message = "The connection with the client (server or slave  ) has failed";
    protected $code = 13;
}

