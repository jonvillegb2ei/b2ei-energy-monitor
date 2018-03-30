<?php

namespace App\Http\Controllers;

use App\Http\Requests\Settings\SetIpAddressRequest;
use App\Libraries\SystemUtils;
use Symfony\Component\Process\Process;

class SettingsController extends Controller
{
    /**
     * Show settings main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $process = new Process ('tail -n 100 '.storage_path('logs/laravel.log'));
        $process->run();
        $applogs = $process->isSuccessful() ? $process->getOutput() : "Error while parsing application logs.";

        $process = new Process ('tail -n 100 /var/log/syslog');
        $process->run();
        $syslogs = $process->isSuccessful() ? $process->getOutput() : "Error while parsing system logs.";

        $process = new Process ('dmesg');
        $process->run();
        $dmesg = $process->isSuccessful() ? $process->getOutput() : "Error while parsing dmesg logs.";

        $process = new Process ('ifconfig eth0 | grep -o -E \'([[:xdigit:]]{1,2}:){5}[[:xdigit:]]{1,2}\'');
        $process->run();
        $mac_address = $process->isSuccessful() ? $process->getOutput() : "";

        return response()->view('administrator.settings', ['syslogs' => $syslogs, 'applogs' => $applogs, 'dmesg' => $dmesg, 'mac_address' => $mac_address]);
    }

    /**
     * Change Ip Address
     *
     * @param SetIpAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setIpAddress(SetIpAddressRequest $request)
    {
        if(in_array($request->input('dhcp-checkbox', false), ['1', 'on'])) {
            if (SystemUtils::setDHCP())
                return redirect()->back()->with('set-ip-success', ['message' => 'Network is now in DHCP mode with a fallback ip as 192.168.0.2 (netmask: 255.255.255.0).']);
            else
                return redirect()->back()->with('set-ip-error', ['message' => 'Error while changing network configuration.']);
        } else if(in_array($request->input('static-checkbox', false), ['1', 'on'])) {
            $address_ip = $request->input('address_ip');
            $netmask = $request->input('netmask');
            $gateway = $request->input('gateway');
            $dns = $request->input('dns');
            if (SystemUtils::setStatic($address_ip,$netmask,$gateway,$dns))
                return redirect()->back()->with('set-ip-success', ['message' => 'Network is now in static mode.']);
            else
                return redirect()->back()->with('set-ip-error', ['message' => 'Error while changing network configuration. Verify your configuration (only IPV4 are supported for the moment).']);
        } else return redirect()->back()->with('set-ip-error', ['message' => 'Unknown action provided.']);
    }

    /**
     * Shutdown the device
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function shutdown()
    {
        if (SystemUtils::shutdown())
            return redirect()->back()->with('system-success', ['message' => 'System is going to shutdown.']);
        else
            return redirect()->back()->with('system-error', ['message' => 'Error while trying to shutdown device. Try to manually power off the device to recover your system.']);
    }

    /**
     * Reboot the device
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reboot()
    {
        if (SystemUtils::reboot())
            return redirect()->back()->with('system-success', ['message' => 'System is going to shutdown.']);
        else
            return redirect()->back()->with('system-error', ['message' => 'Error while trying to shutdown device. Try to manually power off the device to recover your system.']);
    }

    /**
     * Update application
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        if (SystemUtils::update())
            return redirect()->back()->with('system-success', ['message' => 'System will be updating on the next boot.']);
        else
            return redirect()->back()->with('system-error', ['message' => 'Error while trying to create require-update file.']);
    }

    /**
     * Reset device to factory setting (not implemented)
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset()
    {
        return redirect()->back()->with('system-error', ['message' => 'Not implemented yet.']);
    }

}
