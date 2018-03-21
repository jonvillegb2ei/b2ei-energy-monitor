<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class IllegalFunction extends BaseException
{

    public $fatal = false;
    protected $message = "Illegal function (1): The Function Code received in the query is not an allowable ".
                         "action for the server (or slave).  This may be because the ".
                         "function code is only applicable to newer devices, and was ".
                         "not implemented in the unit selected.  It could also indicate ".
                        " that the server (or slave) is in the wrong state to process a ".
                        " request of this type, for example because it is not configured ".
                         "and is being asked to return register values. ";
    protected $code = 1;

}

