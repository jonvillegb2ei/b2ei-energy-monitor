<?php



namespace App\Libraries\LibModbusLaravel\TcpIp;

use App\Libraries\LibModbusLaravel\Contracts\ModbusClient as InterfaceModbusClient;
use App\Libraries\LibModbusLaravel\Contracts\ModbusTcpIpClient as InterfaceModbusTcpIpClient;
use App\Libraries\LibModbusLaravel\Contracts\ModbusRequest as InterfaceModbusRequest;
use App\Libraries\LibModbusLaravel\Contracts\ModbusDataCollection as ModbusDataCollectionInterface;

use App\Libraries\LibModbusLaravel\Exceptions\NoDeviceResponse;
use App\Libraries\LibModbusLaravel\ModbusRequest as ModbusRequest;
use App\Libraries\LibModbusLaravel\ModbusClient as BaseModbusClient;

use App\Libraries\LibModbusLaravel\Exceptions\ConnectionError;
use App\Libraries\LibModbusLaravel\Exceptions\CloseConnectionError;
use App\Libraries\LibModbusLaravel\Exceptions\InvalidFunctionCode;
use App\Libraries\LibModbusLaravel\Exceptions\InvalidSlaveIdentifier;
use App\Libraries\LibModbusLaravel\Exceptions\InvalidDataLength;
use App\Libraries\LibModbusLaravel\Exceptions\ConnectionReadError;
use App\Libraries\LibModbusLaravel\Exceptions\ConnectionWriteError;
use App\Libraries\LibModbusLaravel\ModbusDataCollection;
use Illuminate\Support\Facades\Log;


class ModbusClient extends BaseModbusClient implements InterfaceModbusTcpIpClient
{

    protected $header_length = 6;
    protected $footer_length = 0;
    private $ip_address;
    private $port;


    static public function encodeIntForHeader(int $value) {
        return  strrev(pack( 's' , $value));
    }

    /**
     * @param int $slave
     * @param int $function_code
     * @param ModbusDataCollectionInterface $data
     * @return InterfaceModbusRequest
     */
    static public function getRequest(int $slave, int $function_code, ModbusDataCollectionInterface $data): InterfaceModbusRequest
    {

        $transaction_identifier = self::encodeIntForHeader(0);
        $protocol_identifier = self::encodeIntForHeader(0);
        $data_length = self::encodeIntForHeader(count($data) + 2);
        return
            (new ModbusRequest())
                ->setHeader($transaction_identifier.$protocol_identifier.$data_length)
                ->setSlave($slave)
                ->setFunctionCode($function_code)
                ->setData($data);
    }


    public function checkHeader(string $header)
    {
        if (ord(substr($header,-1, 1)) == 0 and ord(substr($header,-2, 1)) == 0)
            return new NoDeviceResponse();
        return null;
    }


    /**
     * @param string $ip_address
     * @param int $port
     * @return InterfaceModbusClient
     * @throws ConnectionError
     */
    public function connect(string $ip_address, int $port = 502): InterfaceModbusClient
    {
        $this->client = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->client === false) {
            throw new ConnectionError();
        } else {
            $this->ip_address = $ip_address;
            $this->port = $port;
            $result = socket_connect($this->client, $ip_address, $port);
            if ($this->client === false) {
                throw new ConnectionError();
            }
            $this->connected = true;
        }
        return $this ;
    }

    public function __toString()
    {
        return sprintf('Modbus TCP/IP on %s:%s', $this->ip_address, $this->port);
    }

    /**
     * Close communication
     * @throws CloseConnectionError
     */
    public function close():InterfaceModbusClient
    {
        try {
            socket_close($this->client);
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


            Log::debug('Sending data : ');
            Log::debug(collect(str_split($data))->map(function($char) {
                return str_replace(' ','0', sprintf("0x%2X",ord($char)));
            }));

            socket_write($this->client, $data, strlen($data));
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
            $data = socket_read($this->client, $size);


            Log::debug('Receive data : ');
            Log::debug(collect(str_split($data))->map(function($char) {
                return str_replace(' ','0', sprintf("0x%2X",ord($char)));
            }));


            return $data;
        } catch(\Exception $error) {
            throw new ConnectionReadError();
        }
    }


}

