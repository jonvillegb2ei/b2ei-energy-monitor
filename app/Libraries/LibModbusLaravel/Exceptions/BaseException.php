<?php



namespace App\Libraries\LibModbusLaravel\Exceptions;



abstract class BaseException extends \Exception
{

    public $fatal = false;

    public function isFatal($value = null)
    {
        if ($value !== null) $this->fatal = $value;
        return $this->fatal;
    }

    public function fatal($value = null)
    {
        return $this->isFatal($value);
    }

}

