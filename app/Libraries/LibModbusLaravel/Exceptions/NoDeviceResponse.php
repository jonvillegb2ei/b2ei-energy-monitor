<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class NoDeviceResponse extends BaseException
{

    public $fatal = true;
    protected $message = "The device does not respond";
    protected $code = 19;

}

