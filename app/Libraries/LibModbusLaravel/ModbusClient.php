<?php



namespace App\Libraries\LibModbusLaravel;

use App\Libraries\LibModbusLaravel\Contracts\ModbusResponse as InterfaceModbusResponse;
use App\Libraries\LibModbusLaravel\Contracts\ModbusClient as InterfaceModbusClient;
use App\Libraries\LibModbusLaravel\Contracts\ModbusDataCollection as InterfaceModbusDataCollection;
use App\Libraries\LibModbusLaravel\Contracts\ModbusIdentifierResponse as InterfaceModbusIdentifierResponse;
use App\Libraries\LibModbusLaravel\Contracts\ModbusRequest;
use App\Libraries\LibModbusLaravel\Exceptions\ReadUntilConnected;
use App\Libraries\LibModbusLaravel\Exceptions\WriteUntilConnected;


abstract class ModbusClient implements InterfaceModbusClient
{

    protected $client;

    protected $header_length = 0;
    protected $footer_length = 0;

    public $connected = false;

// $deviceIdCode = 01 /02 /03 /04
// $objectId = 0x00 -> 0xFF

    /**
     * @param int $slave
     * @param int $meiType
     * @param int $deviceIdCode
     * @param int $objectId
     * @return InterfaceModbusIdentifierResponse
     * @throws ReadUntilConnected
     */
    public function  readDeviceIdentification(int $slave, int $meiType, int $deviceIdCode, int $objectId = 0x01): InterfaceModbusIdentifierResponse
    {
        if (!$this->connected)
            throw new ReadUntilConnected();
        $data = new ModbusDataCollection();
        $data->writeInt8($meiType);
        $data->writeInt8($deviceIdCode,1);
        $data->writeInt8($objectId,2);
        $request = $this->getRequest($slave, 0x2B, $data);
        $data = $request->getRequest();
        $this->client_write($data);
        return ModbusIdentifierResponse::fromClient($this, $this->header_length, $this->footer_length);
    }

    /**
     * @param int $slave The Slave Address
     * @param int $register
     * @param int $length
     * @return InterfaceModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */
    public function readCoilStatus(int $slave, int $register, int $length): InterfaceModbusResponse
    {
        if (!$this->connected)
            throw new ReadUntilConnected();
        $data = new ModbusDataCollection();
        $data->writeInt16($register);
        $data->writeInt16($length,2);
        $request = $this->getRequest($slave, 0x01, $data);
        return $this->send($request);
    }

    /**
     * This command is requesting the ON/OFF status of discrete inputs # 10197 to 10218
     * from the slave device
     * @param int $slave
     * @param int $register
     * @param int $length
     * @return InterfaceModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */
    public function ReadInputStatus(int $slave, int $register, int $length): InterfaceModbusResponse
    {
        if (!$this->connected)
            throw new ReadUntilConnected();
        $data = new ModbusDataCollection();
        $data->writeInt16($register);
        $data->writeInt16($length,2);
        $request = $this->getRequest($slave, 0x02, $data);
        return $this->send($request);
    }

    /**
     * Read holding register (use Modbus function code 3)
     * This command is requesting the content of analog output holding registers # 40108 to
     * 40110 from the slave device
     * @param int $slave
     * @param int $register
     * @param int $length
     * @return InterfaceModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */


    public function readHoldingRegisters(int $slave, int $register, int $length):InterfaceModbusResponse
    {

        if (!$this->connected)
            throw new ReadUntilConnected();
        $data = new ModbusDataCollection();
        $data->writeUint16($register,0);
        $data->writeUint16($length,2);

        $request = $this->getRequest($slave, 0x03, $data);
        return $this->send($request);
    }


    /**
     * This command is requesting the content of analog input register # 30009
     * from the slave device
     * @param int $slave The Slave Address
     * @param int $register
     * @param int $length
     * @return InterfaceModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */

    public function readInputRegisters(int $slave, int $register, int $length): InterfaceModbusResponse
    {
        if (!$this->connected)
            throw new ReadUntilConnected();
        $data = new ModbusDataCollection();
        $data->writeInt16($register);
        $data->writeInt16($length,2);
        $request = $this->getRequest($slave, 0x04, $data);
        return $this->send($request);
    }


    /**
     * This command is writing the contents of discrete coil # 173 to ON
     * in the slave device
     * @param int $slave
     * @param int $register
     * @param int $value
     * @return InterfaceModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */
    public function forceSingleCoil(int $slave, int $register, int $value): InterfaceModbusResponse
    {
        if (!$this->connected)
            throw new ReadUntilConnected();
        $data = new ModbusDataCollection();
        $data->writeInt16($register);
        $data->writeInt16($value,2);
        $request = $this->getRequest($slave, 0x05, $data);
        return $this->send($request);
    }


    /**
     * This command is writing the contents of analog output holding register # 40002
     * to the slave device
     * @param int $slave The Slave Address
     * @param int $register The Data Address of the register.
     * @param int $value The value to write
     * @return InterfaceModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */
    public function presetSingleRegister(int $slave, int $register, int $value): InterfaceModbusResponse
    {
        if (!$this->connected)
            throw new ReadUntilConnected();
        $data = new ModbusDataCollection();
        $data->writeInt16($register);
        $data->writeInt16($value,2);
        $request = $this->getRequest($slave, 0x06, $data);

        return $this->send($request);
    }


    /**
     * This command is writing the contents of a series of 10 discrete coils from #20 to #29
     * to the slave device with address
     * @param int $slave
     * @param int $register
     * @param int $length
     * @param int $value
     * @return InterfaceModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */
    public function forceMultipleRegister(int $slave, int $register,int $length, int $value): InterfaceModbusResponse
    {
        if (!$this->connected)
            throw new ReadUntilConnected();
        $data = new ModbusDataCollection();
        $data->writeInt16($register);
        $data->writeInt16($length);
        $data->writeInt16($value,2);
        $request = $this->getRequest($slave, 0x0F, $data);
        return $this->send($request);
    }


    /**
     * This command is writing the contents of two analog output holding
     * register # 40002 & 40003 to the slave device
     * @param int $slave
     * @param int $register
     * @param InterfaceModbusDataCollection $data
     * @return ModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */
    public function presetMultipleRegister(int $slave, int $register, InterfaceModbusDataCollection $data): InterfaceModbusResponse
    {
        if (!$this->connected)
            throw new ReadUntilConnected();
        $data_length = count($data);
        $collection = new ModbusDataCollection();
        $collection->writeInt16($register, 0);
        $collection->writeInt16($data_length / 2, 2);
        $collection->writeInt8($data_length,4);
        foreach($data as $octet)
            $collection[] = $octet;
        $request = $this->getRequest($slave, 0x10, $collection);
        return $this->send($request);
    }


    /**
     * @param int $slave
     * @param int $register
     * @param InterfaceModbusDataCollection $data
     * @return InterfaceModbusResponse
     * @throws ReadUntilConnected
     * @throws \Exception
     */
    public function writeHoldingRegisters(int $slave, int $register, InterfaceModbusDataCollection $data): InterfaceModbusResponse
    {
        return $this-> presetMultipleRegister( $slave,  $register , $data);
    }


    /**
     * @param ModbusRequest $request
     * @return  InterfaceModbusResponse
     * @throws \Exception
     */
    public function send(ModbusRequest $request): InterfaceModbusResponse
    {
        $data = $request->getRequest();
        $this->client_write($data);
        return ModbusResponse::fromClient($this, $this->header_length, $this->footer_length);
    }


    public function checkHeader(string $header)
    {
        return null;
    }

    public function checkFooter(string $header, string $request)
    {
        return null;
    }


    /**
     *
     */
    public function __destruct()
    {
        if ($this->connected)
            $this->close();
    }


    public function __toString()
    {
        return '';
    }

}

