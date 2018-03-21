<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class NoResponseData extends BaseException
{

    public $fatal = false;
    protected $message = "No response data ";
    protected $code = 20;

}

