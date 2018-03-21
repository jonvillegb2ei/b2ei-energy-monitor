<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class IllegalDataValue extends BaseException
{

    public $fatal = false;
    protected $message = "Illegal data value (3): The value contained in the query data field is not an allowable".
                         "value for the server (or slave).  This indicates a fault in the".
                          "structure of the remainder of a complex request, such as that ".
                          "the implied length is incorrect.  It specifically does NOT ".
                         " mean that a data item submitted for storage in a register has a ".
                         " value outside the expectation of the application program, ".
                         " since the MODBUS protocol is unaware of the significance of ".
                          "any particular value of any particular register";
    protected $code = 3;

}

