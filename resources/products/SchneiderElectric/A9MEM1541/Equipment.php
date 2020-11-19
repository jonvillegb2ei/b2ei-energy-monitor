<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 17/10/2019
 * Time: 15:00
 */
 
namespace Product\Schneider\A9MEM1541;

use App\Libraries\LibModbusLaravel\ModbusDataCollection;
use App\Libraries\LibModbusLaravel\TcpIp\ModbusClient;
use App\Models\Equipment as EquipmentModel;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use App\Contracts\Equipment as EquipmentInterface;


class Equipment extends EquipmentModel implements EquipmentInterface
{

    private $charts = null;

    public function createVariables ()
    {

        $fiveYears = 60*24*365*5;
        $oneYear = 60*24*365;
        $fiftyMinutes = 15;
        $fiveMinute = 5;

        $this->createVariable('current1', 'A', $fiveMinute, $oneYear);
        $this->createVariable('current2', 'A', $fiveMinute, $oneYear);
        $this->createVariable('current3', 'A', $fiveMinute, $oneYear);
        $this->createVariable('voltage12', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage23', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage31', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage1N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage2N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage3N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('active_power1', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power2', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power3', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_energy', 'kWh', $fiftyMinutes, $fiveYears);
        $this->createVariable('PowerFactor','Pi',$fiveMinute,$oneYear);
        
        return true;
    }

    public function refresh() {
        $client = new ModbusClient();
        $client->connect($this->address_ip, $this->port);
        $response = $client -> readHoldingRegisters($this->slave, 2999, 88);
        $endianness = false;
        if ($response->success()) {
            $this->updateVariable('current1', $response->getData()->withEndianness($endianness)->readFloat32(1));
            $this->updateVariable('current2', $response->getData()->withEndianness($endianness)->readFloat32(3));
            $this->updateVariable('current3', $response->getData()->withEndianness($endianness)->readFloat32(5));
            $this->updateVariable('voltage12', $response->getData()->withEndianness($endianness)->readFloat32(21));
            $this->updateVariable('voltage23', $response->getData()->withEndianness($endianness)->readFloat32(23));
            $this->updateVariable('voltage31', $response->getData()->withEndianness($endianness)->readFloat32(25));
            $this->updateVariable('voltage1N', $response->getData()->withEndianness($endianness)->readFloat32(29));
            $this->updateVariable('voltage2N', $response->getData()->withEndianness($endianness)->readFloat32(31));
            $this->updateVariable('voltage3N', $response->getData()->withEndianness($endianness)->readFloat32(33));
            $this->updateVariable('active_power', $response->getData()->withEndianness($endianness)->readFloat32(61));
            $this->updateVariable('active_power1', $response->getData()->withEndianness($endianness)->readFloat32(55));
            $this->updateVariable('active_power2', $response->getData()->withEndianness($endianness)->readFloat32(57));
            $this->updateVariable('active_power3', $response->getData()->withEndianness($endianness)->readFloat32(59));
          $this->updateVariable('power_factor', $response->getData()->withEndianness($endianness)->readFloat32(85));
            }

          $client = new ModbusClient();
        $client->connect($this->address_ip, $this->port);
        $response = $client -> readHoldingRegisters($this->slave, 3203, 8);
        $endianness = false;
        if ($response->success()) {

            $this->updateVariable('active_energy', $response->getData()->withEndianness($endianness)->readInt64(1));
            
        }
    }


    public function getWidgetVariablesAttribute()
    {
        return $this->variables()
            ->whereIn('name',['active_power','active_energy'])
            ->orderBy('id','ASC')
            ->get();
    }

    public function getCharts() {
        return [
            'voltage' => [
                'id' => 'voltage',
                'title' => 'Voltage',
                'type' =>'line',
                'label' =>'Volts',
                'options' => [
                    'responsive' => true,
                    'legend' => [ 'display' => true, 'position' => 'top', ],
                    'scales' => [ 'xAxes' => [ [ 'type' => 'time', 'time' => [ 'displayFormats' => [ 'quarter' => 'MMM YYYY', ], ], ],], ],
                ],
                'series' => [
                    $this->variables()->whereName('voltage12')->first()->printable_name,
                    $this->variables()->whereName('voltage23')->first()->printable_name,
                    $this->variables()->whereName('voltage31')->first()->printable_name,
                    $this->variables()->whereName('voltage1N')->first()->printable_name,
                    $this->variables()->whereName('voltage2N')->first()->printable_name,
                    $this->variables()->whereName('voltage3N')->first()->printable_name,
                ],
                'data' => function(Carbon $start = null, Carbon $end = null) {
                    if (is_null($start))
                        [$start, $end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $start = $start -> startOfDay();
                        $end = clone $start;
                        $end = $end->addHours(24);
                    }

                    $voltage12Data = $this->variables()->whereName('voltage12')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $voltage23Data = $this->variables()->whereName('voltage23')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $voltage31Data = $this->variables()->whereName('voltage31')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $voltage1NData = $this->variables()->whereName('voltage1N')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $voltage2NData = $this->variables()->whereName('voltage2N')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $voltage3NData = $this->variables()->whereName('voltage3N')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    return [$voltage12Data,$voltage23Data,$voltage31Data,$voltage1NData,$voltage2NData,$voltage3NData];
                }
            ],
            'current' => [
                'id' => 'current',
                'title' => 'Current',
                'type' =>'line',
                'label' =>'Amps',
                'options' => [
                    'responsive' => true,
                    'legend' => [ 'display' => true, 'position' => 'top', ],
                    'scales' => [ 'xAxes' => [ [ 'type' => 'time', 'time' => [ 'displayFormats' => [ 'quarter' => 'MMM YYYY', ], ], ],], ],
                ],
                'series' => [
                    $this->variables()->whereName('current1')->first()->printable_name,
                    $this->variables()->whereName('current2')->first()->printable_name,
                    $this->variables()->whereName('current3')->first()->printable_name,
                    
                ],
                'data' => function(Carbon $start = null, Carbon $end = null) {
                    if (is_null($start))
                        [$start,$end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $end = clone $start;
                        $end = $end -> addHours(24);
                    }

                    $current1Data = $this->variables()->whereName('current1')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $current2Data = $this->variables()->whereName('current2')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $current3Data = $this->variables()->whereName('current3')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    
                    return [$current1Data,$current2Data,$current3Data ];
                }
            ],

            'active_power' => [
                'id' => 'active_power',
                'type' =>'line',
                'title' => 'Active Power',
                'label' =>'kW',
                'options' => [
                    'responsive' => true,
                    'legend' => [ 'display' => true, 'position' => 'top', ],
                    'scales' => [ 'xAxes' => [ [ 'type' => 'time', 'time' => [ 'displayFormats' => [ 'quarter' => 'MMM YYYY', ], ], ],], ],
                ],
                'series' => [
                    $this->variables()->whereName('active_power')->first()->printable_name,
                    $this->variables()->whereName('active_power1')->first()->printable_name,
                    $this->variables()->whereName('active_power2')->first()->printable_name,
                    $this->variables()->whereName('active_power3')->first()->printable_name,
                ],
                'data' => function(Carbon $start = null, Carbon $end = null) {
                    if (is_null($start))
                        [$start, $end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $start = $start -> startOfDay();
                        $end = clone $start;
                        $end = $end->addHours(24);
                    }

                    $activePowerData = $this->variables()->whereName('active_power')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $activePowerData1 = $this->variables()->whereName('active_power1')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $activePowerData2 = $this->variables()->whereName('active_power2')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $activePowerData3 = $this->variables()->whereName('active_power3')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    return [$activePowerData,$activePowerData1,$activePowerData2,$activePowerData3 ];
                }
            ],

        ];
    }


    /**
     * Execute the test command.
     * @return mixed
     * @throws \Exception
     */
    public function test()
    {
        $client = new ModbusClient();
        $client->connect($this->address_ip, $this->port);
        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 2999, 88);
        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

        $current = $response->getData()->withEndianness($endianness)->readFloat32(1);
        $output = sprintf("\ncurrent 1: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(3);
        $output .= sprintf("\ncurrent 2: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(5);
        $output .= sprintf("\ncurrent 3: %.2f A", $current);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(21);
        $output .= sprintf("\nvoltage 12: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(23);
        $output .= sprintf("\nvoltage 23: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(25);
        $output .= sprintf("\nvoltage 31: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(29);
        $output .= sprintf("\nvoltage 1N: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(31);
        $output .= sprintf("\nvoltage 2N: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(33);
        $output .= sprintf("\nvoltage 3N: %.2f VAC", $voltage);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(61);
        $output .= sprintf("\nactive power total: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(55);
        $output .= sprintf("\nactive power L1: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(57);
        $output .= sprintf("\nactive power L2: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(59);
        $output .= sprintf("\nactive power L3: %.2f kW", $power);
      	$power = $response->getData()->withEndianness($endianness)->readFloat32(85);
        $output .= sprintf("\npower factor: %.2f Pi", $power);


        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 3203, 8);
        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

        $power = $response->getData()->withEndianness($endianness)->readInt64(1);
        $output .= sprintf("\nactive energy: %.2f kWh", $power);
    
        return $output;

    }

}



          