<?php
/**
 * Created by PhpStorm.
 * User: sg
 * Date: 15/10/2019
 * Time: 15:00
 */

namespace Product\Socomec\DigiWare\U30;

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


        $this->createVariable('voltage12', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage23', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage31', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage1N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage2N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('voltage3N', 'V', $fiveMinute, $oneYear);
        $this->createVariable('frequency', 'Hz', $fiveMinute, $oneYear);
      
        return true;
    }

        public function refresh() 
        {

        	$client = new ModbusClient();
       		$client->connect($this->address_ip, $this->port);
        	$response = $client -> readHoldingRegisters($this->slave, 36871, 18);
        	$endianness = false;
        	if ($response->success()) {

            	$this->updateVariable('voltage12', $response->getData()->withEndianness($endianness)->readUint32(9)/100);
            	$this->updateVariable('voltage23', $response->getData()->withEndianness($endianness)->readUint32(11)/100);
           	 	$this->updateVariable('voltage31', $response->getData()->withEndianness($endianness)->readUint32(13)/100);
           		$this->updateVariable('voltage1N', $response->getData()->withEndianness($endianness)->readUint32(3)/100);
           	 	$this->updateVariable('voltage2N', $response->getData()->withEndianness($endianness)->readUint32(5)/100);
            	$this->updateVariable('voltage3N', $response->getData()->withEndianness($endianness)->readUint32(7)/100);
            	$this->updateVariable('frequency', $response->getData()->withEndianness($endianness)->readUint32(1)/1000);
       		}
        }   
    

    public function getWidgetVariablesAttribute()
    {
        return $this->variables()
            ->whereIn('name',['voltage1N','voltage2N','voltage3N','frequency'])
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
        $response = $client -> readHoldingRegisters($this->slave == 0 ? 255 : $this->slave, 36871, 18);

        $endianness = false;
        if ($response->hasException())
            throw $response->getException();
        if (!$response->success())
            return false;

        $voltage = $response->getData()->withEndianness($endianness)->readUint32(9);
        $output  = sprintf("\nvoltage 12: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(11);
        $output .= sprintf("\nvoltage 23: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(13);
        $output .= sprintf("\nvoltage 31: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(3);
        $output .= sprintf("\nvoltage 1N: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(5);
        $output .= sprintf("\nvoltage 2N: %.2f VAC", $voltage/100);
        $voltage = $response->getData()->withEndianness($endianness)->readUint32(7);
        $output .= sprintf("\nvoltage 3N: %.2f VAC", $voltage/100);
        $frequency = $response->getData()->withEndianness($endianness)->readUint32(1);
        $output .= sprintf("\nfrequency: %.2f Hz", $frequency/1000);
       
        return $output;
    }

}

			
