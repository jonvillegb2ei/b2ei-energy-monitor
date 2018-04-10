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
                return redirect()->back()->with('set-ip-success', ['message' => trans('settings.ip-config.dhcp-enable')]);
            else
                return redirect()->back()->with('set-ip-error', ['message' => trans('settings.ip-config.error')]);
        } else if(in_array($request->input('static-checkbox', false), ['1', 'on'])) {
            $address_ip = $request->input('address_ip');
            $netmask = $request->input('netmask');
            $gateway = $request->input('gateway');
            $dns = $request->input('dns');
            if (SystemUtils::setStatic($address_ip,$netmask,$gateway,$dns))
                return redirect()->back()->with('set-ip-success', ['message' => trans('settings.ip-config.static-enable')]);
            else
                return redirect()->back()->with('set-ip-error', ['message' => trans('settings.ip-config.config-error')]);
        } else return redirect()->back()->with('set-ip-error', ['message' => trans('settings.ip-config.action-error')]);
    }

    /**
     * Shutdown the device
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function shutdown()
    {
        if (SystemUtils::shutdown())
            return redirect()->back()->with('system-success', ['message' => trans('settings.ip-config.shutdown-success')]);
        else
            return redirect()->back()->with('system-error', ['message' => trans('settings.ip-config.shutdown-error')]);
    }

    /**
     * Reboot the device
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reboot()
    {
        if (SystemUtils::reboot())
            return redirect()->back()->with('system-success', ['message' => trans('settings.ip-config.reboot-success')]);
        else
            return redirect()->back()->with('system-error', ['message' => trans('settings.ip-config.reboot-error')]);
    }

    /**
     * Update application
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        if (SystemUtils::update())
            return redirect()->back()->with('system-success', ['message' => trans('settings.ip-config.update-success')]);
        else
            return redirect()->back()->with('system-error', ['message' => trans('settings.ip-config.update-error')]);
    }

    /**
     * Reset device to factory setting (not implemented)
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset()
    {
        return redirect()->back()->with('system-error', ['message' => trans('app.not-implemented-yet')]);
    }

}
