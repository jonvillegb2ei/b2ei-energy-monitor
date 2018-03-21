<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class GatewayTargetDeviceFailedToRespond extends BaseException
{

    public $fatal = true;
    protected $message = "Gateway target device failed to respond (11): Indicates that no response was obtained from the target device.".
                          "Usually means that the device is not present on the network. ";
    protected $code = 11;

}

