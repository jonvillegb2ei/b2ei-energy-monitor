<?php



namespace App\Libraries\LibModbusLaravel\Exceptions\Modbus;



use App\Libraries\LibModbusLaravel\Exceptions\BaseException;

class SlaveDeviceBusy extends BaseException
{

    public $fatal = false;
    protected $message = "SlaveDeviceBusy (6): Specialized use in conjunction with programming commands.".
                         " The server (of slave) is engaged in processing a long-duration ".
                         " program command.  The client (or master) should retransmit ".
                         " the message later when the server (or slave) is free. ";
    protected $code = 6;
}

