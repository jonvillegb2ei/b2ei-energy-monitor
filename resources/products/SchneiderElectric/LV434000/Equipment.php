<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 20/02/2018
 * Time: 15:42
 */

namespace Product\SchneiderElectric\LV434000;

use App\Contracts\Equipment as EquipmentInterface;
use App\Libraries\LibModbusLaravel\ModbusDataCollection;
use App\Libraries\LibModbusLaravel\TcpIp\ModbusClient;
use App\Models\Equipment as EquipmentModel;
use Carbon\Carbon;

class Equipment extends EquipmentModel implements EquipmentInterface
{

    private $charts = null;

    public function createVariables ()
    {

        $fiveYears = 60 * 24 * 365 * 5;
        $oneYear = 60 * 24 * 365;
        $fiftyMinutes = 15;
        $fiveMinute = 5;


        $this->createVariable('state', 'ON/OFF', $fiftyMinutes, $fiveYears, 'boolean');
        $this->createVariable('fault', 'FAULT/OK', $fiftyMinutes, $fiveYears, 'boolean');
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

    // App\Models\Equipment::first()->refresh()

    public function refresh ()
    {
        $client = new ModbusClient();
        $client->connect($this->address_ip, $this->port);
        $response = $client->readHoldingRegisters(255, 32000, 124);
        $endianness = false;
        if ($response->success()) {
            $states = $response->getData()->withEndianness($endianness)->readBitmap(1, ModbusDataCollection::BIT_16);
            $this->updateVariable('state', $states[0] ? 1 : 0);
            $this->updateVariable('fault', ($states[1] or $states[2]) ? 1 : 0);
            $this->updateVariable('current1', $response->getData()->withEndianness($endianness)->readFloat32(28));
            $this->updateVariable('current2', $response->getData()->withEndianness($endianness)->readFloat32(30));
            $this->updateVariable('current3', $response->getData()->withEndianness($endianness)->readFloat32(32));
            $this->updateVariable('currentN', $response->getData()->withEndianness($endianness)->readFloat32(34));

            $this->updateVariable('voltage12', $response->getData()->withEndianness($endianness)->readFloat32(56));
            $this->updateVariable('voltage23', $response->getData()->withEndianness($endianness)->readFloat32(58));
            $this->updateVariable('voltage31', $response->getData()->withEndianness($endianness)->readFloat32(60));
            $this->updateVariable('voltage1N', $response->getData()->withEndianness($endianness)->readFloat32(62));
            $this->updateVariable('voltage2N', $response->getData()->withEndianness($endianness)->readFloat32(64));
            $this->updateVariable('voltage3N', $response->getData()->withEndianness($endianness)->readFloat32(66));

            $this->updateVariable('frequency', $response->getData()->withEndianness($endianness)->readFloat32(68));

            $this->updateVariable('active_power1', $response->getData()->withEndianness($endianness)->readFloat32(72));
            $this->updateVariable('active_power2', $response->getData()->withEndianness($endianness)->readFloat32(74));
            $this->updateVariable('active_power3', $response->getData()->withEndianness($endianness)->readFloat32(76));

            $this->updateVariable('active_power', $response->getData()->withEndianness($endianness)->readFloat32(78));
            $this->updateVariable('reactive_power1', $response->getData()->withEndianness($endianness)->readFloat32(80));
            $this->updateVariable('reactive_power2', $response->getData()->withEndianness($endianness)->readFloat32(82));
            $this->updateVariable('reactive_power3', $response->getData()->withEndianness($endianness)->readFloat32(84));
            $this->updateVariable('reactive_power', $response->getData()->withEndianness($endianness)->readFloat32(86));
            $this->updateVariable('apparent_power1', $response->getData()->withEndianness($endianness)->readFloat32(88));
            $this->updateVariable('apparent_power2', $response->getData()->withEndianness($endianness)->readFloat32(90));
            $this->updateVariable('apparent_power3', $response->getData()->withEndianness($endianness)->readFloat32(92));
            $this->updateVariable('apparent_power', $response->getData()->withEndianness($endianness)->readFloat32(94));

            $this->updateVariable('active_energy', $response->getData()->withEndianness($endianness)->readInt64(96));
            $this->updateVariable('reactive_energy', $response->getData()->withEndianness($endianness)->readInt64(100));
            $this->updateVariable('apparent_energy', $response->getData()->withEndianness($endianness)->readInt64(120));
        }
    }

    public function getWidgetVariablesAttribute ()
    {
        return $this->variables()
            ->whereIn('name', ['active_power', 'reactive_power', 'apparent_power', 'active_energy'])
            ->orderBy('id', 'ASC')
            ->get();
    }


    public function getCharts ()
    {
        return [
            'voltage' => [
                'id' => 'voltage',
                'title' => 'Voltage',
                'type' => 'line',
                'label' => 'Volts',
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
                'data' => function (Carbon $start = null, Carbon $end = null) {
                    if (is_null($start))
                        [$start, $end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $end = clone $start;
                        $end = $end->addHours(24);
                    }
                    $voltage12Data = $this->variables()->whereName('voltage12')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    $voltage23Data = $this->variables()->whereName('voltage23')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    $voltage31Data = $this->variables()->whereName('voltage31')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    return ['L12' => $voltage12Data->pluck('value'), 'L23' => $voltage23Data->pluck('value'), 'L31' => $voltage31Data->pluck('value')];
                }
            ],
            'current' => [
                'id' => 'current',
                'title' => 'Current',
                'type' => 'line',
                'label' => 'Amps',
                'options' => [
                    'responsive' => true,
                    'legend' => [ 'display' => true, 'position' => 'top', ],
                    'scales' => [ 'xAxes' => [ [ 'type' => 'time', 'time' => [ 'displayFormats' => [ 'quarter' => 'MMM YYYY', ], ], ],], ],
                ],
                'series' => [
                    $this->variables()->whereName('current1')->first()->printable_name,
                    $this->variables()->whereName('current2')->first()->printable_name,
                    $this->variables()->whereName('current3')->first()->printable_name,
                    $this->variables()->whereName('currentN')->first()->printable_name,
                ],
                'data' => function (Carbon $start = null, Carbon $end = null) {
                    if (is_null($start))
                        [$start, $end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $end = clone $start;
                        $end = $end->addHours(24);
                    }
                    $current1Data = $this->variables()->whereName('current1')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    $current2Data = $this->variables()->whereName('current2')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    $current3Data = $this->variables()->whereName('current3')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    $currentNData = $this->variables()->whereName('currentN')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    return ['L1' => $current1Data->pluck('value'), 'L2' => $current2Data->pluck('value'), 'L3' => $current3Data->pluck('value'), 'N' => $currentNData->pluck('value')];
                }
            ],
            'active_power' => [
                'id' => 'active_power',
                'title' => 'Active Power',
                'type' => 'line',
                'label' => 'kW',
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
                'data' => function (Carbon $start = null, Carbon $end = null) {
                    if (is_null($start))
                        [$start, $end] = [Carbon::now()->subHours(24), Carbon::now()];
                    if (is_null($end)) {
                        $end = clone $start;
                        $end = $end->addHours(24);
                    }
                    $activePowerData = $this->variables()->whereName('active_power')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    $activePowerData1 = $this->variables()->whereName('active_power1')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    $activePowerData2 = $this->variables()->whereName('active_power2')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    $activePowerData3 = $this->variables()->whereName('active_power3')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at', 'ASC')->get();
                    return ['Total' => $activePowerData->pluck('value'), 'L1' => $activePowerData1->pluck('value'), 'L2' => $activePowerData2->pluck('value'), 'L3' => $activePowerData3->pluck('value')];
                }
            ],
        ];
    }


    /**
     * Execute the test command.
     * @return mixed
     * @throws \Exception
     */
    public function test ()
    {
        $client = new ModbusClient();
        $client->connect($this->address_ip, $this->port);
        $response = $client->readHoldingRegisters($this->slave, 32000, 124);
        $endianness = false;

        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;
        $states = $response->getData()->withEndianness($endianness)->readBitmap(1);
        $output = sprintf("\nstates: %s %s", $states[0] ? 'ON' : 'OFF', $states[1] ? 'FAULT' : 'OK');
        $current = $response->getData()->withEndianness($endianness)->readFloat32(18);
        $output .= sprintf("\ncurrent 1: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(30);
        $output .= sprintf("\ncurrent 2: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(32);
        $output .= sprintf("\ncurrent 3: %.2f A", $current);
        $current = $response->getData()->withEndianness($endianness)->readFloat32(34);
        $output .= sprintf("\ncurrent N: %.2f A", $current);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(56);
        $output .= sprintf("\nvoltage 12: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(58);
        $output .= sprintf("\nvoltage 23: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(60);
        $output .= sprintf("\nvoltage 31: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(62);
        $output .= sprintf("\nvoltage 1N: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(64);
        $output .= sprintf("\nvoltage 2N: %.2f VAC", $voltage);
        $voltage = $response->getData()->withEndianness($endianness)->readFloat32(66);
        $output .= sprintf("\nvoltage 3N: %.2f VAC", $voltage);
        $frequency = $response->getData()->withEndianness($endianness)->readFloat32(68);
        $output .= sprintf("\nfrequency: %.2f Hz", $frequency);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(72);
        $output .= sprintf("\nactive power L1: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(74);
        $output .= sprintf("\nactive power L2: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(76);
        $output .= sprintf("\nactive power L3: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(78);
        $output .= sprintf("\nactive power total: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(80);
        $output .= sprintf("\nreactive power L1: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(82);
        $output .= sprintf("\nreactive power L2: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(84);
        $output .= sprintf("\nreactive power L3: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(86);
        $output .= sprintf("\nreactive power total: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(88);
        $output .= sprintf("\napparent power L1: %.2f kVA", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(90);
        $output .= sprintf("\napparent power L2: %.2f kVA", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(92);
        $output .= sprintf("\napparent power L3: %.2f kVA", $power);
        $power = $response->getData()->withEndianness($endianness)->readFloat32(94);
        $output .= sprintf("\napparent power total: %.2f kVA", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(96);
        $output .= sprintf("\nactive energy: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(100);
        $output .= sprintf("\nreactive energy: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(104);
        $output .= sprintf("\nactive energy counted positively: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(108);
        $output .= sprintf("\nactive energy counted negatively: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(112);
        $output .= sprintf("\nreactive energy counted positively: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(116);
        $output .= sprintf("\nreactive energy counted negatively: %.2f kWh", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt64(120);
        $output .= sprintf("\ntotal apparent energy: %.2f kWh", $power);
        return $output;

    }


}
