<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



class ConnectionReadError extends BaseException
{

    public $fatal = true;
    protected $message = 'Connexion in read mode to fail';
    protected $code = 14;

}

