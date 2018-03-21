<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class NegativeAcknowledge extends BaseException
{

    public $fatal = false;
    protected $message = "Negative acknowledge (7): The program function just requested cannot b performed.";
    protected $code = 7;
}

