<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class AcknowledgeError extends BaseException
{

    public $fatal = false;

    protected $message = "Acknowledge (5): The server (or slave) has accepted the request and is".
                          "processing it, but long duration of time will be required to do ".
                          "so.  This response is returned to prevent a timeout error from ".
                          "occurring in the client (or master). ";
    protected $code = 5;
}

