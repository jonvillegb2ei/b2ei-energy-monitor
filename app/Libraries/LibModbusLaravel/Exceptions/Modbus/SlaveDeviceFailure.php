<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class SlaveDeviceFailure extends BaseException
{

    public $fatal = false;
    protected $message = "Slave device failure (4): An Unrecoverable error occurred while the server (or slave)".
                          "was attempting to perform the requested action.";
    protected $code = 4;
}

