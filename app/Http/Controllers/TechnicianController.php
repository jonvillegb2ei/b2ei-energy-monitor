<?php

namespace App\Http\Controllers;

use App\Http\Requests\Technician\CreateEquipmentRequest;
use App\Http\Requests\Technician\EditEquipmentRequest;
use App\Http\Requests\Technician\EditVariableRequest;
use App\Http\Requests\Technician\IdentifyRequest;
use App\Http\Requests\Technician\PingRequest;
use App\Http\Requests\Technician\ReadRegistersRequest;
use App\Libraries\LibModbusLaravel\ModbusDataCollection;
use App\Libraries\LibModbusLaravel\TcpIp\ModbusClient;
use App\Models\Equipment;
use App\Models\Product;
use App\Models\Variable;
use Symfony\Component\Process\Process;

class TechnicianController extends Controller
{

    /**
     * Show technician main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        return response()->view('administrator.technician', ['products' => Product::all()]);
    }

    /**
     * Get equipments table data with pagination
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function equipments() {
        $equipments = Equipment::paginate(8);
        foreach($equipments as $equipment) {
            $equipment->offsetSet('routes', [
                'ping' => route('technician.equipment.ping', ['equipment' => $equipment]),
                'test' => route('technician.equipment.test', ['equipment' => $equipment]),
                'detail' => route('technician.equipment.detail', ['equipment' => $equipment]),
            ]);
        }
        return $equipments;
    }

    /**
     * Get equipment data
     *
     * @param Equipment $equipment
     * @return Equipment
     */
    public function equipment(Equipment $equipment) {
        return $equipment;
    }

    /**
     * Get app log file content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function applogs()
    {
        $process = new Process ('tail -n 100 ' . storage_path('logs/laravel.log'));
        $process->run();
        return response()->json(['return' => $process->isSuccessful(), 'content' => $process->isSuccessful() ? $process->getOutput() : trans('technician.app-log-error')]);
    }

    /**
     * Get system log file content
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function syslogs()
    {
        $process = new Process ('tail -n 100 /var/log/syslog');
        $process->run();
        $syslogs = $process->isSuccessful() ? $process->getOutput() : trans('technician.system-log-error');

        $process = new Process ('dmesg');
        $process->run();
        $dmesg = $process->isSuccessful() ? $process->getOutput() : trans('technician.dmesg-log-error');

        return response()->json(['return' => true, 'syslogs' => $syslogs, 'dmesg' => $dmesg]);
    }

    /**
     * Show equipment detail page.
     *
     * @param Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function detail (Equipment $equipment)
    {
        return response()->view('administrator.technician_components.detail', ['equipment' => $equipment]);
    }

    /**
     * Ping an address IP
     *
     * @param PingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ping (PingRequest $request)
    {
        $address = $request->input('address_ip');
        $process = new Process ('ping -c 3 ' . escapeshellarg($address));
        $process->run();
        if (!$process->isSuccessful())
            return response()->json(['return' => false, 'message' => trans('technician.ping.error'), 'output' => $process->getOutput()]);
        else
            return response()->json(['return' => true, 'message' => trans('technician.ping.success'), 'output' => $process->getOutput()]);
    }

    /**
     * Ping an address IP from an equipment
     *
     * @param Equipment $equipment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function pingEquipment (Equipment $equipment)
    {
        $address = $equipment->address_ip;
        $process = new Process ('ping -c 3 ' . escapeshellarg($address));
        $process->run();
        if (!$process->isSuccessful())
            return response()->json(['return' => false, 'message' => trans('technician.ping.error'), 'output' => $process->getOutput()]);
        else
            return response()->json(['return' => true, 'message' => trans('technician.ping.success'), 'output' => $process->getOutput()]);
    }

    /**
     * Get equipment variables
     *
     * @param Equipment $equipment
     * @return Variable[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function variables(Equipment $equipment)
    {
        return $equipment->variables;
    }

    /**
     * Edit variable log_expiration and log_interval
     *
     * @param EditVariableRequest $request
     * @param Variable $variable
     * @return \Illuminate\Http\JsonResponse
     */
    public function editVariable(EditVariableRequest $request, Variable $variable)
    {
        $variable->log_expiration = $request->input('log_expiration', 0);
        $variable->log_interval = $request->input('log_interval', 0);
        if ($variable->save()) return response()->json(['return' => true, 'message' => trans('technician.variable.success')]);
        else return response()->json(['return' => false, 'message' => trans('technician.variable.error')]);
    }

    /**
     * Edit equipment data.
     *
     * @param EditEquipmentRequest $request
     * @param Equipment $equipment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editEquipment (EditEquipmentRequest $request, Equipment $equipment)
    {
        $equipment->name = $request->input('name');
        $equipment->address_ip = $request->input('address_ip');
        $equipment->port = $request->input('port');
        $equipment->slave = $request->input('slave');
        $equipment->localisation = $request->input('localisation');
        if ($equipment->save())
            return response()->json(['return' => true, 'message' => trans('technician.equipment-edit.success')]);
        else
            return response()->json(['return' => false, 'message' => trans('technician.equipment-edit.error')]);
    }

    /**
     * Remove an equipment.
     *
     * @param Equipment $equipment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove (Equipment $equipment)
    {
        if ($equipment->delete())
            return redirect()->route('technician')->with('equipment-success', ['message' => trans('technician.remove-success'), 'output' => '']);
        else
            return redirect()->back()->with('remove-error', ['message' => trans('technician.remove-error')]);
    }

    /**
     * Add an equipment.
     *
     * @param CreateEquipmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addEquipment (CreateEquipmentRequest $request)
    {
        $equipment = Equipment::create($request->all());
        if ($equipment instanceof Equipment) {
            $equipment = Equipment::whereId($equipment->id)->first();
            $equipment->createVariables();
            return response()->json(['return'=>true, 'message' => trans('technician.equipment-create.success')]);
        } else
            return response()->json(['return'=>false, 'message' => trans('technician.equipment-create.error')]);
    }

    /**
     * Test an equipment.
     *
     * @param Equipment $equipment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function testEquipment (Equipment $equipment)
    {
        try {
            $output = $equipment->test();
            if (!$output)
                return response()->json(['return' => false, 'message' => trans('technician.test-error'), 'output' => '']);
            else
                return response()->json(['return' => true, 'message' => trans('technician.test-success'), 'output' => $output]);
        } catch (\Exception $e) {
            return response()->json(['return' => false, 'message' => trans('technician.test-error'), 'output' => $e->getMessage()]);
        }
    }

    /**
     * Identify an equipment.
     *
     * @param IdentifyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify (IdentifyRequest $request)
    {
        $client = new ModbusClient();
        $address_ip = $request->input('address_ip');
        $port = $request->input('port', 502);
        $slave = $request->input('slave', 1);
        $mei_type = $request->input('mei_type', 1);
        $device_id = $request->input('device_id', 4);
        try {
            $client->connect($address_ip, $port);
            $response = $client->readDeviceIdentification($slave, $mei_type, $device_id);
            if ($response->success())
                return response()->json(['return' => true, 'message' => trans('technician.identify.success'),
                    'output' => $response->getObjects()->map(function (ModbusDataCollection $object) {
                        return $object->asIdentifierString();
                    })->implode(', ') ]);
            else if ($response->hasException())
                return response()->json(['return' => false, 'message' => trans('technician.identify.error'), 'output' => $response->getException()->getMessage()]);
            else
                return response()->json(['return' => false, 'message' => trans('technician.identify.error'), 'output' => '']);
        } catch (\Exception $e) {
            return response()->json(['return' => false, 'message' => trans('technician.identify.error'), 'output' => '']);
        }
    }

    /**
     * Read some register on a given device.
     *
     * @param ReadRegistersRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function readRegisters (ReadRegistersRequest $request)
    {
        $client = new ModbusClient();
        $address_ip = $request->input('address_ip');
        $port = $request->input('port', 502);
        $slave = $request->input('slave', 1);
        $register = $request->input('register', 1);
        $length = $request->input('length', 1);
        $registers = collect(range(1,60))->map(function($element) { return ['index' => $element, 'value'=> 0, 'class_name'=> '']; });
        try {
            $client->connect($address_ip, $port);
            $response = $client->readHoldingRegisters($slave, $register, $length);
            if ($response->success()) {
                for ($i = 0; $i < $length; $i++) {
                    $value = $response->getData()->withEndianness(false)->readUint16($i);
                    $registers[$i] = ['index' => $i+1, 'value'=> $value, 'class_name'=> 'has-success'];
                }
                return response()->json(['return' => true, 'registers' => $registers, 'message' => trans('technician.modbus-client.success'), 'output' => trans('technician.modbus-client.data-length') . ($response->getData()->count() / 2)]);
            } else if ($response->hasException())
                return response()->json(['return' => false, 'registers' => $registers, 'message' => trans('technician.modbus-client.error'), 'output' => $response->getException()->getMessage()]);
            else
                return response()->json(['return' => false, 'registers' => $registers, 'message' => trans('technician.modbus-client.error'), 'output' => trans('technician.unknown-error')]);
        } catch (\Exception $e) {
            return response()->json(['return' => false, 'registers' => $registers, 'message' => trans('technician.modbus-client.error'), 'output' => $e->getMessage()]);
        }
    }
}
