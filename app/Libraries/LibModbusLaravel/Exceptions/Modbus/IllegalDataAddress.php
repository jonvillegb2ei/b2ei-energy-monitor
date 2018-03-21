<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class IllegalDataAddress extends BaseException
{

    public $fatal = false;
    protected $message = "Illegal data address (2): The data address received in the query is not an allowable ".
        "address for the server (or slave).  More specifically, the ".
        "combination of reference number and transfer length is ".
        "invalid.";
    protected $code = 2;

}

