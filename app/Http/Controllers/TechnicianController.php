<?php

namespace App\Http\Controllers;

use App\Http\Requests\Technician\CreateEquipmentRequest;
use App\Http\Requests\Technician\EditEquipmentRequest;
use App\Http\Requests\Technician\IdentifyRequest;
use App\Http\Requests\Technician\PingRequest;
use App\Http\Requests\Technician\ReadRegistersRequest;
use App\Libraries\LibModbusLaravel\ModbusDataCollection;
use App\Libraries\LibModbusLaravel\TcpIp\ModbusClient;
use App\Models\Equipment;
use App\Models\Product;
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
        $products = Product::all();
        $equipments = Equipment::all();

        $process = new Process ('tail -n 100 ' . storage_path('logs/laravel.log'));
        $process->run();
        $applogs = $process->isSuccessful() ? $process->getOutput() : "Error while parsing application logs.";

        $process = new Process ('tail -n 100 /var/log/syslog');
        $process->run();
        $syslogs = $process->isSuccessful() ? $process->getOutput() : "Error while parsing system logs.";

        $process = new Process ('dmesg');
        $process->run();
        $dmesg = $process->isSuccessful() ? $process->getOutput() : "Error while parsing dmesg logs.";

        return response()->view('administrator.technician', ['equipments' => $equipments, 'products' => $products, 'syslogs' => $syslogs, 'applogs' => $applogs, 'dmesg' => $dmesg]);
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
            return redirect()->back()->with('ping-error', ['message' => 'Error during ping.', 'output' => $process->getOutput()])->withInput();
        else
            return redirect()->back()->with('ping-success', ['message' => 'Device reply with a pong.', 'output' => $process->getOutput()])->withInput();
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
            return redirect()->back()->with('equipment-error', ['message' => 'Error during ping.', 'output' => $process->getOutput()]);
        else
            return redirect()->back()->with('equipment-success', ['message' => 'Device reply with a pong.', 'output' => $process->getOutput()]);
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
            return redirect()->back()->with('edit-success', ['message' => 'Equipment edited with success.']);
        else
            return redirect()->back()->with('edit-error', ['message' => 'Error during equipment update.']);
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
            return redirect()->route('technician')->with('equipment-success', ['message' => 'Equipment removed with success.', 'output' => '']);
        else
            return redirect()->back()->with('remove-error', ['message' => 'Error during equipment deletion.']);
    }
// App\Models\Equipment::whereId(4)->first()
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
            return redirect()->back()->with('create-success', ['message' => 'Equipment created with success.']);
        } else
            return redirect()->back()->with('create-error', ['message' => 'Error during equipment creation.']);
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
            if ($output)
                return redirect()->back()->with('equipment-success', ['message' => 'Test output : ', 'output' => $output])->withInput();
            else
                return redirect()->back()->with('equipment-error', ['message' => 'Error during equipment test.', 'output' => ''])->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('equipment-error', ['message' => 'Error during equipment test.', 'output' => $e->getMessage()])->withInput();
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
                return redirect()->back()->with('identify-success', ['message' => "Device reply with identification data.",
                    'output' => $response->getObjects()->map(function (ModbusDataCollection $object) {
                        return $object->asIdentifierString();
                    })->implode(', ')])->withInput();
            else if ($response->hasException())
                return redirect()->back()->with('identify-error', ['message' => "Can't identify device.", 'output' => $response->getException()->getMessage()])->withInput();
            else return redirect()->back()->with('identify-error', ['message' => "Can't identify device.", 'output' => ''])->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('identify-error', ['message' => "Can't identify device.", 'output' => $e->getMessage()])->withInput();
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

        try {
            $client->connect($address_ip, $port);
            $response = $client->readHoldingRegisters($slave, $register, $length);
            if ($response->success()) {
                for ($i = 0; $i < 50; $i++)
                    session()->flash('register_' . $i, 0);
                for ($i = 0; $i < $response->getData()->count() / 2; $i+=1) {
                    $value = $response->getData()->withEndianness()->readUint16($i*2);
                    session()->flash('register_' . $i, $value);
                }
                return redirect()->back()->with('modbus-client-success', ['message' => "Device reply with data.",
                    'output' => 'Data length: ' . ($response->getData()->count() / 2)])->withInput();
            } else if ($response->hasException())
                return redirect()->back()->with('modbus-client-error', ['message' => "Can't read registers.", 'output' => $response->getException()->getMessage()])->withInput();
            else
                return redirect()->back()->with('modbus-client-error', ['message' => "Can't read registers.", 'output' => ''])->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('modbus-client-error', ['message' => "Can't read registers.", 'output' => $e->getMessage()])->withInput();
        }
    }
}
