<?php

namespace App\Console\Commands;

use App\Libraries\LibModbusLaravel\ModbusDataCollection;
use App\Libraries\LibModbusLaravel\TcpIp\ModbusClient;
use App\Models\Equipment;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//
//        for ($i=0;$i<180;$i++) {
//            \App\Models\Variable::all()->each(function($variable) {
//                $this->line($variable->name." => ".$variable->value);
//            });
//            $this->line('');
//            sleep(1);
//        }
//
//        return null;
        $client = new ModbusClient();
        $client->connect('192.168.2.186', 502);
        $response = $client -> readHoldingRegisters(255, 32000, 124);
//        $client->connect('192.168.1.64', 502);
//        $response = $client -> readHoldingRegisters(10, 12000, 64);
        $endianness = false;

        $equipment = Equipment::where('id', 8)->first();

        dd($equipment->test());


        $states = $response->getData()->withEndianness($endianness)->readBitmap(1);
//        dd($states);
//        printf("\nstates: %s %s", $states[0] ? 'ON' : 'OFF', $states[1] ? 'FAULT' : 'OK');
//        $current = $response->getData()->withEndianness($endianness)->readUint16(28);
//        printf("\ncurrent 1: %.2f A", $current);

//        $voltage = $response->getData()->withEndianness($endianness)->readUint16(29);
//        $output = sprintf("\nvoltage 12: %.2f VAC", $voltage);
//        $voltage = $response->getData()->withEndianness($endianness)->readUint16(30);
//        $output .= sprintf("\nvoltage 23: %.2f VAC", $voltage);
//        $voltage = $response->getData()->withEndianness($endianness)->readUint16(31);
//        $output .= sprintf("\nvoltage 31: %.2f VAC", $voltage);

//    dd($output);

        $current = $response->getData()->withEndianness($endianness)->readFloat32(28);
        printf("\ncurrent 1: %.2f A", $current);

        $current = $response->getData()->withEndianness($endianness)->readFloat32(30);
        printf("\ncurrent 2: %.2f A", $current);

        $current = $response->getData()->withEndianness($endianness)->readFloat32(32);
        printf("\ncurrent 3: %.2f A", $current);


        $current = $response->getData()->withEndianness($endianness)->readFloat32(34);
        printf("\ncurrent N: %.2f A", $current);



        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(56);
        printf("\nvoltage 12: %.2f VAC", $voltage);

        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(58);
        printf("\nvoltage 23: %.2f VAC", $voltage);

        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(60);
        printf("\nvoltage 31: %.2f VAC", $voltage);


        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(62);
        printf("\nvoltage 1N: %.2f VAC", $voltage);

        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(64);
        printf("\nvoltage 2N: %.2f VAC", $voltage);

        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(66);
        printf("\nvoltage 3N: %.2f VAC", $voltage);



        $frequency = $response->getData()->withEndianness($endianness)->readFloat32(68);
        printf("\nfrequency: %.2f Hz", $frequency);

        $frequency = $response->getData()->withEndianness($endianness)->readFloat32(70);
        printf("\nmax frequency: %.2f Hz", $frequency);


        $power = $response->getData()->withEndianness($endianness)->readFloat32(72);
        printf("\nactive power L1: %.2f kW", $power);



        $power = $response->getData()->withEndianness($endianness)->readFloat32(74);
        printf("\nactive power L2: %.2f kW", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(76);
        printf("\nactive power L3: %.2f kW", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(78);
        printf("\nactive power total: %.2f kW", $power);





        $power = $response->getData()->withEndianness($endianness)->readFloat32(80);
        printf("\nreactive power L1: %.2f kVAR", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(82);
        printf("\nreactive power L2: %.2f kVAR", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(84);
        printf("\nreactive power L3: %.2f kVAR", $power);



        $power = $response->getData()->withEndianness($endianness)->readFloat32(86);
        printf("\nreactive power total: %.2f kVAR", $power);





        $power = $response->getData()->withEndianness($endianness)->readFloat32(88);
        printf("\napparent power L1: %.2f kVA", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(90);
        printf("\napparent power L2: %.2f kVA", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(92);
        printf("\napparent power L3: %.2f kVA", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(94);
        printf("\napparent power total: %.2f kVA", $power);





        $power = $response->getData()->withEndianness($endianness)->readInt64(96);
        printf("\nactive energy: %.2f kWh", $power);



        $power = $response->getData()->withEndianness($endianness)->readInt64(100);
        printf("\nreactive energy: %.2f kWh", $power);

        $power = $response->getData()->withEndianness($endianness)->readInt64(104);
        printf("\nactive energy counted positively: %.2f kWh", $power);

        $power = $response->getData()->withEndianness($endianness)->readInt64(108);
        printf("\nactive energy counted negatively: %.2f kWh", $power);



        $power = $response->getData()->withEndianness($endianness)->readInt64(112);
        printf("\nreactive energy counted positively: %.2f kWh", $power);

        $power = $response->getData()->withEndianness($endianness)->readInt64(116);
        printf("\nreactive energy counted negatively: %.2f kWh", $power);



        $power = $response->getData()->withEndianness($endianness)->readInt64(120);
        printf("\ntotal apparent energy: %.2f kWh", $power);


        exit(0);


    }
}
