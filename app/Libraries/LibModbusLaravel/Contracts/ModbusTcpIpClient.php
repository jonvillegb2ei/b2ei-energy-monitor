<?php


namespace App\Libraries\LibModbusLaravel\Contracts;



Interface ModbusTcpIpClient extends ModbusClient
{

    /**
     * @param string $ip_address
     * @param int $port
     * @return ModbusClient
     */
    public function connect(string $ip_address, int $port = 502):ModbusClient;


}

