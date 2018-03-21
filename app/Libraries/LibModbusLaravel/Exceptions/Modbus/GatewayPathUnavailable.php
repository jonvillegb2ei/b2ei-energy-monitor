<?php

namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;


use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class GatewayPathUnavailable extends BaseException
{

    public $fatal = false;
    protected $message = "Gateway path unavailable (10): The gateway was unable to allocate an internal".
                          "communication path from the input port to the out port for ".
                         " processing the request. ";
    protected $code = 10;
}

