<?php


namespace App\Libraries\LibModbusLaravel\Contracts;



Interface ModbusRTUClient extends ModbusClient
{


    /**
     * @param string $com_port
     * @param int $speed
     * @param string $parity
     * @param int $data_size
     * @param int $stop_size
     *
     * @return ModbusClient
     */
    public function connect(string $com_port, int $speed, string $parity, int $data_size = 8, int $stop_size = 1):ModbusClient;



}

