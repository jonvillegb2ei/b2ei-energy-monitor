<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class MemoryParityError extends BaseException
{

    public $fatal = false;
    protected $message = " Memory parity error (8): The server (or slave) attempted to read record file, but".
                         "detected a parity error in the memory.  The client (or master) ".
                        " can retry the request, but service may be required on the ".
                        " server (or slave) device. ";
    protected $code = 8;
}

