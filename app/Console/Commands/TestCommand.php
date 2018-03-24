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
        $response = $client -> readHoldingRegisters(255, 31999, 124);
//        $client->connect('192.168.1.64', 502);
//        $response = $client -> readHoldingRegisters(10, 12000, 64);
        $endianness = false;

        $equipment = Equipment::where('id', 5)->first();

        dd($equipment->test());


        $states = $response->getData()->withEndianness($endianness)->readBitmap(1, ModbusDataCollection::BIT_16);
//        dd($states);
        printf("\nstates: %s %s", $states[0] ? 'ON' : 'OFF', $states[1] ? 'FAULT' : 'OK');
//        $current = $response->getData()->withEndianness($endianness)->readUint16(28);
//        printf("\ncurrent 1: %.2f A", $current);

//        $voltage = $response->getData()->withEndianness($endianness)->readUint16(29);
//        $output = sprintf("\nvoltage 12: %.2f VAC", $voltage);
//        $voltage = $response->getData()->withEndianness($endianness)->readUint16(30);
//        $output .= sprintf("\nvoltage 23: %.2f VAC", $voltage);
//        $voltage = $response->getData()->withEndianness($endianness)->readUint16(31);
//        $output .= sprintf("\nvoltage 31: %.2f VAC", $voltage);

//    dd($output);

        $current = $response->getData()->withEndianness($endianness)->readFloat32(27);
        printf("\ncurrent 1: %.2f A", $current);

        $current = $response->getData()->withEndianness($endianness)->readFloat32(29);
        printf("\ncurrent 2: %.2f A", $current);

        $current = $response->getData()->withEndianness($endianness)->readFloat32(31);
        printf("\ncurrent 3: %.2f A", $current);


        $current = $response->getData()->withEndianness($endianness)->readFloat32(33);
        printf("\ncurrent N: %.2f A", $current);



        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(55);
        printf("\nvoltage 12: %.2f VAC", $voltage);

        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(57);
        printf("\nvoltage 23: %.2f VAC", $voltage);

        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(59);
        printf("\nvoltage 31: %.2f VAC", $voltage);


        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(61);
        printf("\nvoltage 1N: %.2f VAC", $voltage);

        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(63);
        printf("\nvoltage 2N: %.2f VAC", $voltage);

        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(65);
        printf("\nvoltage 3N: %.2f VAC", $voltage);



        $frequency = $response->getData()->withEndianness($endianness)->readFloat32(67);
        printf("\nfrequency: %.2f Hz", $frequency);

        $frequency = $response->getData()->withEndianness($endianness)->readFloat32(69);
        printf("\nmax frequency: %.2f Hz", $frequency);


        $power = $response->getData()->withEndianness($endianness)->readFloat32(71);
        printf("\nactive power L1: %.2f kW", $power);



        $power = $response->getData()->withEndianness($endianness)->readFloat32(73);
        printf("\nactive power L2: %.2f kW", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(75);
        printf("\nactive power L3: %.2f kW", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(77);
        printf("\nactive power total: %.2f kW", $power);





        $power = $response->getData()->withEndianness($endianness)->readFloat32(79);
        printf("\nreactive power L1: %.2f kVAR", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(81);
        printf("\nreactive power L2: %.2f kVAR", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(83);
        printf("\nreactive power L3: %.2f kVAR", $power);



        $power = $response->getData()->withEndianness($endianness)->readFloat32(85);
        printf("\nreactive power total: %.2f kVAR", $power);





        $power = $response->getData()->withEndianness($endianness)->readFloat32(87);
        printf("\napparent power L1: %.2f kVA", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(89);
        printf("\napparent power L2: %.2f kVA", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(91);
        printf("\napparent power L3: %.2f kVA", $power);

        $power = $response->getData()->withEndianness($endianness)->readFloat32(93);
        printf("\napparent power total: %.2f kVA", $power);





        $power = $response->getData()->withEndianness($endianness)->readInt64(95);
        printf("\nactive energy: %.2f kWh", $power);



        $power = $response->getData()->withEndianness($endianness)->readInt64(99);
        printf("\nreactive energy: %.2f kWh", $power);

        $power = $response->getData()->withEndianness($endianness)->readInt64(103);
        printf("\nactive energy counted positively: %.2f kWh", $power);

        $power = $response->getData()->withEndianness($endianness)->readInt64(107);
        printf("\nactive energy counted negatively: %.2f kWh", $power);



        $power = $response->getData()->withEndianness($endianness)->readInt64(111);
        printf("\nreactive energy counted positively: %.2f kWh", $power);

        $power = $response->getData()->withEndianness($endianness)->readInt64(115);
        printf("\nreactive energy counted negatively: %.2f kWh", $power);



        $power = $response->getData()->withEndianness($endianness)->readInt64(119);
        printf("\ntotal apparent energy: %.2f kWh", $power);


        exit(0);


    }
}
