<?php



namespace App\Libraries\LibModbusLaravel\RTU;


use App\Libraries\LibModbusLaravel\Contracts\ModbusRTUClient as InterfaceModbusRTUClient;
use App\Libraries\LibModbusLaravel\Contracts\ModbusClient as InterfaceModbusClient;
use App\Libraries\LibModbusLaravel\Contracts\ModbusRequest as InterfaceModbusRequest;
use App\Libraries\LibModbusLaravel\Contracts\ModbusDataCollection as InterfaceModbusDataCollection;
use App\Libraries\LibModbusLaravel\Exceptions\InvalidCRC;
use App\Libraries\LibModbusLaravel\ModbusClient as BaseModbusClient;
use App\Libraries\LibModbusLaravel\ModbusRequest as ModbusRequest;
use App\Libraries\LibModbusLaravel\Exceptions\ConnectionError;
use App\Libraries\LibModbusLaravel\Exceptions\ConnectionReadError;
use App\Libraries\LibModbusLaravel\Exceptions\ConnectionWriteError;
use App\Libraries\LibModbusLaravel\Exceptions\CloseConnectionError;


class ModbusClient extends BaseModbusClient implements InterfaceModbusRTUClient

{

    protected $header_length = 0;
    protected $footer_length = 2;


    /**
     * @var $client
     */
    protected $client;
    private $comPort;
    private $speed;
    private $parity;
    private $data_size;
    private $stop_size;

    /**
     * @param int $slave
     * @param int $function_code
     * @param InterfaceModbusDataCollection $data
     * @return InterfaceModbusRequest
     * @throws \App\Libraries\LibModbusLaravel\Exceptions\InvalidSlaveIdentifier
     */
    static public function getRequest(int $slave, int $function_code, InterfaceModbusDataCollection $data):InterfaceModbusRequest
    {
        return (new ModbusRequest())
                ->setSlave($slave)
                ->setFunctionCode($function_code)
                ->setData($data)
                ->withCrc16();
    }



    /**
     * @param string $com_port
     * @param int $speed
     * @param string $parity
     * @param int $data_size
     * @param int $stop_size
     *
     * @return InterfaceModbusClient
     * @throws ConnectionError
     */
    public function connect(string $com_port, int $speed, string $parity, int $data_size = 8, int $stop_size = 1):InterfaceModbusClient
    {
        try {
            $this->comPort = $com_port;
            $this->speed = $speed;
            $this->parity = $parity;
            $this->data_size = $data_size;
            $this->stop_size = $stop_size;

            $parityString = array(
                "none" => "-parenb",
                "odd"  => "parenb parodd",
                "even" => "parenb -parodd",
            );
            system('stty -F '.escapeshellarg($com_port).' '.escapeshellarg($speed) );
            system('stty -F '.escapeshellarg($com_port).' '.$parityString[strtolower($parity)]);
            system('stty -F '.escapeshellarg($com_port).' -cstopb');
            system('stty -F '.escapeshellarg($com_port).' clocal -crtscts -ixon -ixoff');
            system('stty -F '.escapeshellarg($com_port).' -brkint -icrnl -imaxbel -opost -isig -icanon -echo -echoe');
            $this->client = fopen($com_port, 'r+b');
            stream_set_blocking($this->client, true);
            $this->connected = true;
        } catch(\Exception $error) {
            throw new ConnectionError($error->getMessage());
        }
        return $this;
    }

    public function __toString()
    {
        return sprintf('Modbus RTU on %s speed: %s, parity: %s, data size: %s, stop size: %s', $this->comPort, $this->speed, $this->parity, $this->data_size, $this->stop_size);
    }


    public function checkFooter(string $footer, string $request)
    {
        if ( /* check crc 32 is invalid */ false)
            return new InvalidCRC();
        return null;
    }


    /**
     * Close communication
     * @throws CloseConnectionError
     */
    public function close():InterfaceModbusClient
    {
        try {
            fclose($this->client);
        } catch(\Exception $error) {
            throw new CloseConnectionError();
        }
        return $this;
    }




    /**
     * @param string $data
     * @return InterfaceModbusClient
     * @throws ConnectionWriteError
     */
    public function client_write(string $data): InterfaceModbusClient
    {

        try {
            fwrite($this->client, $data);
        } catch(\Exception $error) {
            throw new ConnectionWriteError();
        }
        return $this;
    }



    /**
     * @param int|null $size
     * @return string
     * @throws ConnectionReadError
     */
    public function client_read(int $size = null): string
    {
        try {
            $read = [$this->client];
            $write = null;
            $except = null;
            $connected = stream_select($read, $write, $except, 1);
            if (!$connected)
                throw new ConnectionReadError();
            return fread($this->client, is_null($size) ? 1 : $size);
        } catch(\Exception $error) {throw new ConnectionReadError();}
    }

}

