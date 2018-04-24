<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 20/02/2018
 * Time: 15:42
 */

namespace Product\SchneiderElectric\IEM3250;

use App\Contracts\Equipment as EquipmentInterface;
use App\Libraries\LibModbusLaravel\ModbusDataCollection;
use App\Libraries\LibModbusLaravel\TcpIp\ModbusClient;
use App\Models\Equipment as EquipmentModel;
use Carbon\Carbon;

class Equipment extends EquipmentModel implements EquipmentInterface
{


    public function createVariables ()
    {

        $fiveYears = 60*24*365*5;
        $oneYear = 60*24*365;
        $fiftyMinutes = 15;
        $fiveMinute = 5;

        $this->createVariable('current1', 'A', $fiveMinute, $oneYear);
        $this->createVariable('current2', 'A', $fiveMinute, $oneYear);
        $this->createVariable('current3', 'A', $fiveMinute, $oneYear);
        $this->createVariable('currentAVG', 'A', $fiveMinute, $oneYear);
        $this->createVariable('voltage12', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage23', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage31', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage1N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage2N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage3N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('frequency', 'Hz', $fiveMinute, $oneYear);
        $this->createVariable('power_factor', 'Pi', $fiveMinute, $oneYear);
        $this->createVariable('active_power1', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power2', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power3', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_energy', 'kWh', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_energy1', 'kWh', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_energy2', 'kWh', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_energy3', 'kWh', $fiftyMinutes, $fiveYears);
        return true;
    }

    public function refresh() {
        $client = new ModbusClient();
        $client->connect($this->address_ip, $this->port);
        $response = $client -> readHoldingRegisters($this->slave, 2999, 112);
        $endianness = false;
        if ($response->success()) {
            $this->updateVariable('current1', $response->getData()->withEndianness($endianness)->readFloat32(0));
            $this->updateVariable('current2', $response->getData()->withEndianness($endianness)->readFloat32(2));
            $this->updateVariable('current3', $response->getData()->withEndianness($endianness)->readFloat32(4));
            $this->updateVariable('currentAVG', $response->getData()->withEndianness($endianness)->readFloat32(6));
            $this->updateVariable('voltage12', $response->getData()->withEndianness($endianness)->readFloat32(20));
            $this->updateVariable('voltage23', $response->getData()->withEndianness($endianness)->readFloat32(22));
            $this->updateVariable('voltage31', $response->getData()->withEndianness($endianness)->readFloat32(24));
            $this->updateVariable('voltage1N', $response->getData()->withEndianness($endianness)->readFloat32(28));
            $this->updateVariable('voltage2N', $response->getData()->withEndianness($endianness)->readFloat32(30));
            $this->updateVariable('voltage3N', $response->getData()->withEndianness($endianness)->readFloat32(32));
            $this->updateVariable('frequency', $response->getData()->withEndianness($endianness)->readFloat32(110));
        }

        $response = $client -> readHoldingRegisters($this->slave, 3199, 6);
        $endianness = false;
        if ($response->success()) {
            $this->updateVariable('active_energy', $response->getData()->withEndianness($endianness)->readInt64(4));
        }

        $response = $client -> readHoldingRegisters($this->slave, 3499, 30);
        $endianness = false;
        if ($response->success()) {
            $this->updateVariable('active_power1', $response->getData()->withEndianness($endianness)->readFloat32(18));
            $this->updateVariable('active_power2', $response->getData()->withEndianness($endianness)->readFloat32(22));
            $this->updateVariable('active_power3', $response->getData()->withEndianness($endianness)->readFloat32(26));
        }

    }

    public function getWidgetVariablesAttribute()
    {
        return $this->variables()
            ->whereIn('name',['active_power','active_energy','currentAVG','frequency'])
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
                    return [$voltage12Data, $voltage23Data, $voltage31Data, $voltage1NData, $voltage2NData, $voltage3NData ];
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
                    $this->variables()->whereName('currentAVG')->first()->printable_name,
                ],
                'data' => function(Carbon $start = null, Carbon $end = null) {
                    if (is_null($start))
                        [$start, $end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $start = $start -> startOfDay();
                        $end = clone $start;
                        $end = $end->addHours(24);
                    }
                    $current1Data = $this->variables()->whereName('current1')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $current2Data = $this->variables()->whereName('current2')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $current3Data = $this->variables()->whereName('current3')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $currentNData = $this->variables()->whereName('currentAVG')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    return [$current1Data, $current2Data, $current3Data, $currentNData ];
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
                    return [$activePowerData, $activePowerData1, $activePowerData2, $activePowerData3 ];
                }
            ],

            'power_factor' => [
                'id' => 'power_factor',
                'type' =>'line',
                'title' => 'Power factor',
                'label' =>'Pi',
                'options' => [
                    'responsive' => true,
                    'legend' => [ 'display' => true, 'position' => 'top', ],
                    'scales' => [ 'xAxes' => [ [ 'type' => 'time', 'time' => [ 'displayFormats' => [ 'quarter' => 'MMM YYYY', ], ], ],], ],
                ],
                'series' => [
                    $this->variables()->whereName('power_factor')->first()->printable_name,
                ],
                'data' => function(Carbon $start = null, Carbon $end = null) {
                    if (is_null($start))
                        [$start, $end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $start = $start -> startOfDay();
                        $end = clone $start;
                        $end = $end->addHours(24);
                    }
                    $powerFactor = $this->variables()->whereName('power_factor')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    return [$powerFactor ];
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
        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 2999, 112);
        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

        $current = $response->getData()->withEndianness($endianness)->readFloat32(0);
        $output = sprintf("\ncurrent 1: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(2);
        $output .= sprintf("\ncurrent 2: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(4);
        $output .= sprintf("\ncurrent 3: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(10);
        $output .= sprintf("\ncurrent AVG: %.2f A", $current);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(20);
        $output .= sprintf("\nvoltage 12: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(22);
        $output .= sprintf("\nvoltage 23: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(24);
        $output .= sprintf("\nvoltage 31: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(28);
        $output .= sprintf("\nvoltage 1N: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(30);
        $output .= sprintf("\nvoltage 2N: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(32);
        $output .= sprintf("\nvoltage 3N: %.2f VAC", $voltage);
        $frequency = $response->getData()->withEndianness($endianness)->readFloat32(110);
        $output .= sprintf("\nfrequency: %.2f Hz", $frequency);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(54);
        $output .= sprintf("\nactive power L1: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(56);
        $output .= sprintf("\nactive power L2: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(58);
        $output .= sprintf("\nactive power L3: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(60);
        $output .= sprintf("\nactive power total: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(84);
        $output .= sprintf("\npower factor: %.2f PI", $power);

        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 3499, 30);
        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

        $power = $response->getData()->withEndianness($endianness)->readInt64(18);
        $output .= sprintf("\nactive energy L1: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(22);
        $output .= sprintf("\nactive energy L2: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(26);
        $output .= sprintf("\nactive energy L3: %.2f kWh", $power);

        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 3199, 30);
        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

        $power = $response->getData()->withEndianness($endianness)->readInt64(4);
        $output .= sprintf("\nactive energy total: %.2f kWh", $power);

        return $output;
    }

}


