<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 15/10/2019
 * Time: 15:00
 */

namespace Product\Socomec\DigiWare\I30;
use App\Libraries\LibModbusLaravel\ModbusDataCollection;
use App\Libraries\LibModbusLaravel\TcpIp\ModbusClient;
use App\Models\Equipment as EquipmentModel;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use App\Contracts\Equipment as EquipmentInterface;


class Equipment extends EquipmentModel implements EquipmentInterface
{

    private $charts = null;
    public $iCharge=1;

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
        $this->createVariable('PowerFactor','Pi',$fiveMinute,$oneYear);
        return true;
    }


        public function refresh() 
        {

        	$client = new ModbusClient();
       		$client->connect($this->address_ip, $this->port);
        	$response = $client -> readHoldingRegisters($this->slave, 16394+$this->iCharge*2048, 48);
        	$endianness = false;
        	if ($response->success()) {

            	$this->updateVariable('current1', $response->getData()->withEndianness($endianness)->readUint32(17)/1000);
           		$this->updateVariable('current2', $response->getData()->withEndianness($endianness)->readUint32(19)/1000);
            	$this->updateVariable('current3', $response->getData()->withEndianness($endianness)->readUint32(21)/1000);
            	$this->updateVariable('currentN', $response->getData()->withEndianness($endianness)->readUint32(23)/1000);
            	$this->updateVariable('voltage12', $response->getData()->withEndianness($endianness)->readUint32(11)/100);
            	$this->updateVariable('voltage23', $response->getData()->withEndianness($endianness)->readUint32(13)/100);
           	 	$this->updateVariable('voltage31', $response->getData()->withEndianness($endianness)->readUint32(15)/100);
           		$this->updateVariable('voltage1N', $response->getData()->withEndianness($endianness)->readUint32(3)/100);
           	 	$this->updateVariable('voltage2N', $response->getData()->withEndianness($endianness)->readUint32(5)/100);
            	$this->updateVariable('voltage3N', $response->getData()->withEndianness($endianness)->readUint32(7)/100);
            	$this->updateVariable('frequency', $response->getData()->withEndianness($endianness)->readUint32(1)/1000);
            	$this->updateVariable('active_power', $response->getData()->withEndianness($endianness)->readInt32(35));
            	$this->updateVariable('reactive_power', $response->getData()->withEndianness($endianness)->readInt32(37));
            	$this->updateVariable('apparent_power', $response->getData()->withEndianness($endianness)->readUint32(43));
            	$this->updateVariable('power_factor', $response->getData()->withEndianness($endianness)->readInt16(45)/1000);

           		$response = $client -> readHoldingRegisters($this->slave, 17793+$this->iCharge*2048, 16);
            	$endianness = false;
            	if ($response->success()) {

                	$this->updateVariable('active_energy', $response->getData()->withEndianness($endianness)->readUint32(1)/1000);
                	$this->updateVariable('reactive_energy', $response->getData()->withEndianness($endianness)->readUint32(7)/1000);
                	$this->updateVariable('apparent_energy', $response->getData()->withEndianness($endianness)->readUint32(13)/1000);
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
                    $this->variables()->whereName('currentN')->first()->printable_name,
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
                    $currentNData = $this->variables()->whereName('currentN')->first()->logs()->where('created_at', '>=', $start)->where('created_at', '<=', $end)->orderBy('created_at','ASC')->get()->map(function($log) {return [ 'x' => $log->created_at->format("Y-m-d H:i:s"), 'y' => $log->value ]; });
                    return [$current1Data,$current2Data,$current3Data,$currentNData ];
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
        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 16394+$this->iCharge*2048, 48);

        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

        $current = $response->getData()->withEndianness($endianness)->readUint32(17);
        $output  = sprintf("\ncurrent 1: %.2f A", $current/1000);
        $current = $response->getData()->withEndianness($endianness)->readUint32(19);
        $output .= sprintf("\ncurrent 2: %.2f A", $current/1000);
        $current = $response->getData()->withEndianness($endianness)->readUint32(21);
        $output .= sprintf("\ncurrent 3: %.2f A", $current/1000);
        $current = $response->getData()->withEndianness($endianness)->readUint32(23);
        $output .= sprintf("\ncurrent N: %.2f A", $current/1000);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(11);
        $output .= sprintf("\nvoltage 12: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(13);
        $output .= sprintf("\nvoltage 23: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(15);
        $output .= sprintf("\nvoltage 31: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(3);
        $output .= sprintf("\nvoltage 1N: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(5);
        $output .= sprintf("\nvoltage 2N: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(7);
        $output .= sprintf("\nvoltage 3N: %.2f VAC", $voltage/100);
        $frequency = $response->getData()->withEndianness($endianness)->readUint32(1);
        $output .= sprintf("\nfrequency: %.2f Hz", $frequency/1000);
        $power = $response->getData()->withEndianness($endianness)->readInt32(35);
        $output .= sprintf("\nactive power total: %.2f kW", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt32(37);
        $output .= sprintf("\nreactive power total: %.2f kVAR", $power);
        $power = $response->getData()->withEndianness($endianness)->readUint32(43);
        $output .= sprintf("\napparent power total: %.2f kVA", $power);
        $power = $response->getData()->withEndianness($endianness)->readInt16(45);
        $output .= sprintf("\npower factor: %.2f Pi", $power/1000);
        
        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 17793+$this->iCharge*2048, 16);
        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

        $power = $response->getData()->withEndianness($endianness)->readUint32(1);
        $output .= sprintf("\nactive energy: %.2f kWh", $power/1000);
        $power = $response->getData()->withEndianness($endianness)->readUint32(7);
        $output .= sprintf("\nreactive energy: %.2f kWh", $power/1000);
        $power = $response->getData()->withEndianness($endianness)->readUint32(13);
        $output .= sprintf("\ntotal apparent energy: %.2f kWh", $power/1000);

        return $output;
    }

}

