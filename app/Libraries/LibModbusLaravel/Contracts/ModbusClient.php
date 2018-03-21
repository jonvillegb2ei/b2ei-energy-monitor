<?php


namespace App\Libraries\LibModbusLaravel\Contracts;



Interface ModbusClient
{


    /**
     * Close communication
     */
    public function close():ModbusClient;


    public function send(ModbusRequest $request): ModbusResponse;

    /**
     * Read holding register (use Modbus function code 4) 
     * 
     * @param int $slave
     * @param int $register
     * @param int $length
     * @return ModbusResponse
     */
    public function readHoldingRegisters(int $slave, int $register, int $length): ModbusResponse;

    /**
     * Read holding register (use Modbus function code 4)
     *
     * @param int $slave
     * @param int $register
     * @param ModbusDataCollection $data
     * @return ModbusResponse
     */
    public function writeHoldingRegisters(int $slave, int $register, ModbusDataCollection $data): ModbusResponse;


    /**
     * @param int $slave
     * @param int $function_code
     * @param ModbusDataCollection $data
     * @return ModbusRequest
     */
    static public function getRequest(int $slave, int $function_code, ModbusDataCollection $data): ModbusRequest;

    /**
     * @param string $data
     * @return ModbusClient
     */
    public function client_write(string $data): ModbusClient;

    /**
     * @param int|null $size
     * @return ModbusDataCollection
     */
    public function client_read(int $size = null): string;




    public function  readDeviceIdentification(int $slave, int $meiType, int $deviceIdCode, int $objectId = 0x01): ModbusIdentifierResponse;
}

