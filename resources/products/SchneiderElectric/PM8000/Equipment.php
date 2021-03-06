<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 20/02/2018
 * Time: 15:42
 */

namespace Product\SchneiderElectric\PM8000;

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
        $this->createVariable('currentN', 'A', $fiveMinute, $oneYear);
        $this->createVariable('voltage12', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage23', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage31', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage1N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage2N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage3N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('frequency', 'Hz', $fiveMinute, $oneYear);
        $this->createVariable('active_power1', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power2', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power3', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_power', 'kW', $fiftyMinutes, $fiveYears);
        $this->createVariable('reactive_power', 'kVAR', $fiftyMinutes, $fiveYears);
        $this->createVariable('reactive_power1', 'kVAR', $fiftyMinutes, $fiveYears);
        $this->createVariable('reactive_power2', 'kVAR', $fiftyMinutes, $fiveYears);
        $this->createVariable('reactive_power3', 'kVAR', $fiftyMinutes, $fiveYears);
        $this->createVariable('apparent_power', 'kVA', $fiftyMinutes, $fiveYears);
        $this->createVariable('apparent_power1', 'kVA', $fiftyMinutes, $fiveYears);
        $this->createVariable('apparent_power2', 'kVA', $fiftyMinutes, $fiveYears);
        $this->createVariable('apparent_power3', 'kVA', $fiftyMinutes, $fiveYears);
        $this->createVariable('active_energy', 'kWh', $fiftyMinutes, $fiveYears);
        $this->createVariable('reactive_energy', 'kVARh', $fiftyMinutes, $fiveYears);
        $this->createVariable('apparent_energy', 'kVAh', $fiftyMinutes, $fiveYears);
        return true;
    }

    public function refresh() {
        $client = new ModbusClient();
        $client->connect($this->address_ip, $this->port);
        $response = $client -> readHoldingRegisters($this->slave, 2997, 120);
        $endianness = false;
        if ($response->success()) {
            $this->updateVariable('current1', $response->getData()->withEndianness($endianness)->readFloat32(2));
            $this->updateVariable('current2', $response->getData()->withEndianness($endianness)->readFloat32(4));
            $this->updateVariable('current3', $response->getData()->withEndianness($endianness)->readFloat32(6));
            $this->updateVariable('currentN', $response->getData()->withEndianness($endianness)->readFloat32(8));
            $this->updateVariable('voltage12', $response->getData()->withEndianness($endianness)->readFloat32(22));
            $this->updateVariable('voltage23', $response->getData()->withEndianness($endianness)->readFloat32(24));
            $this->updateVariable('voltage31', $response->getData()->withEndianness($endianness)->readFloat32(26));
            $this->updateVariable('voltage1N', $response->getData()->withEndianness($endianness)->readFloat32(30));
            $this->updateVariable('voltage2N', $response->getData()->withEndianness($endianness)->readFloat32(32));
            $this->updateVariable('voltage3N', $response->getData()->withEndianness($endianness)->readFloat32(34));
            $this->updateVariable('frequency', $response->getData()->withEndianness($endianness)->readFloat32(112));
            $this->updateVariable('active_power1', $response->getData()->withEndianness($endianness)->readFloat32(56));
            $this->updateVariable('active_power2', $response->getData()->withEndianness($endianness)->readFloat32(58));
            $this->updateVariable('active_power3', $response->getData()->withEndianness($endianness)->readFloat32(60));
            $this->updateVariable('active_power', $response->getData()->withEndianness($endianness)->readFloat32(62));
            $this->updateVariable('reactive_power1', $response->getData()->withEndianness($endianness)->readFloat32(64));
            $this->updateVariable('reactive_power2', $response->getData()->withEndianness($endianness)->readFloat32(66));
            $this->updateVariable('reactive_power3', $response->getData()->withEndianness($endianness)->readFloat32(68));
            $this->updateVariable('reactive_power', $response->getData()->withEndianness($endianness)->readFloat32(70));
            $this->updateVariable('apparent_power1', $response->getData()->withEndianness($endianness)->readFloat32(72));
            $this->updateVariable('apparent_power2', $response->getData()->withEndianness($endianness)->readFloat32(74));
            $this->updateVariable('apparent_power3', $response->getData()->withEndianness($endianness)->readFloat32(76));
            $this->updateVariable('apparent_power', $response->getData()->withEndianness($endianness)->readFloat32(78));

            $response = $client -> readHoldingRegisters($this->slave, 2697, 28);
            $endianness = false;
            if ($response->success()) {
                $this->updateVariable('active_energy', $response->getData()->withEndianness($endianness)->readFloat32(2));
                $this->updateVariable('reactive_energy', $response->getData()->withEndianness($endianness)->readFloat32(10));
                $this->updateVariable('apparent_energy', $response->getData()->withEndianness($endianness)->readFloat32(20));
            }
        }
    }

    public function getWidgetVariablesAttribute()
    {
        return $this->variables()
            ->whereIn('name',['active_power','reactive_power','apparent_power','active_energy'])
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
                    return [$voltage12Data, $voltage23Data, $voltage31Data];
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
                        [$start, $end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $start = $start -> startOfDay();
                        $end = clone $start;
                        $end = $end->addHours(24);
                    }
                    $current1Data = $this->variables()->whereName('current1')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $current2Data = $this->variables()->whereName('current2')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    $current3Data = $this->variables()->whereName('current3')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    return [$current1Data, $current2Data, $current3Data];
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
        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 2997, 120);
        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;
//        $states = $response->getData()->withEndianness($endianness)->readBitmap(1, ModbusDataCollection::BIT_16);
//        $output = sprintf("states: %s %s", $states[0] ? 'ON' : 'OFF', ($states[1] or $states[2]) ? 'FAULT' : 'OK');
        $current = $response->getData()->withEndianness($endianness)->readFloat32(2);
        $output = sprintf("\ncurrent 1: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(4);
        $output .= sprintf("\ncurrent 2: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(6);
        $output .= sprintf("\ncurrent 3: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(8);
        $output .= sprintf("\ncurrent N: %.2f A", $current);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(22);
        $output .= sprintf("\nvoltage 12: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(24);
        $output .= sprintf("\nvoltage 23: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(26);
        $output .= sprintf("\nvoltage 31: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(30);
        $output .= sprintf("\nvoltage 1N: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(32);
        $output .= sprintf("\nvoltage 2N: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(34);
        $output .= sprintf("\nvoltage 3N: %.2f VAC", $voltage);
        $frequency = $response->getData()->withEndianness($endianness)->readFloat32(112);
        $output .= sprintf("\nfrequency: %.2f Hz", $frequency);
//        $frequency = $response->getData()->withEndianness($endianness)->readFloat32(69);
//        $output .= sprintf("\nmax frequency: %.2f Hz", $frequency / 10);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(56);
        $output .= sprintf("\nactive power L1: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(58);
        $output .= sprintf("\nactive power L2: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(60);
        $output .= sprintf("\nactive power L3: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(62);
        $output .= sprintf("\nactive power total: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(64);
        $output .= sprintf("\nreactive power L1: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(66);
        $output .= sprintf("\nreactive power L2: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(68);
        $output .= sprintf("\nreactive power L3: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(70);
        $output .= sprintf("\nreactive power total: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(72);
        $output .= sprintf("\napparent power L1: %.2f kVA", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(74);
        $output .= sprintf("\napparent power L2: %.2f kVA", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(76);
        $output .= sprintf("\napparent power L3: %.2f kVA", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(78);
        $output .= sprintf("\napparent power total: %.2f kVA", $power);



        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 2697, 28);
        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

//        dd($response->getData());
        $power = $response->getData()->withEndianness($endianness)->readFloat32(2);
        $output .= sprintf("\nactive energy: %.2f kWh", $power);
//
        $power = $response->getData()->withEndianness($endianness)->readFloat32(10);
        $output .= sprintf("\nreactive energy: %.2f kWh", $power);
//        $power = $response->getData()->withEndianness($endianness)->readInt64(103);
//        $output .= sprintf("\nactive energy counted positively: %.2f kWh", $power);
//        $power = $response->getData()->withEndianness($endianness)->readInt64(107);
//        $output .= sprintf("\nactive energy counted negatively: %.2f kWh", $power);
//        $power = $response->getData()->withEndianness($endianness)->readInt64(111);
//        $output .= sprintf("\nreactive energy counted positively: %.2f kWh", $power);
//        $power = $response->getData()->withEndianness($endianness)->readInt64(115);
//        $output .= sprintf("\nreactive energy counted negatively: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(20);
        $output .= sprintf("\ntotal apparent energy: %.2f kWh", $power);
        return $output;
    }


}
