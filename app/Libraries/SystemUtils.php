<?php

namespace App\Libraries;

use Symfony\Component\Process\Process;

// App\Libraries\SystemUtils::update()
// App\Libraries\SystemUtils::reboot()
// App\Libraries\SystemUtils::shutdown()
// App\Libraries\SystemUtils::getConfig()
// App\Libraries\SystemUtils::setDHCP()
// App\Libraries\SystemUtils::setStatic('192.168.2.24','255.255.0.0','192.168.1.51','192.168.1.51 8.8.8.8 8.8.4.4')


class SystemUtils {

    static public function getBinaryPath()
    {
        return realpath(app_path('../systemutils'));
    }

    static public function getConfigContent() {

        $process = new Process ('sudo '. (self::getBinaryPath()));
        $process->run();
        return $process->isSuccessful() ? $process->getOutput() : '';
    }

    static public function parseAddressIpWthNetmask($address) {
        $parts = explode('/',$address);
        $netmask = '';
        if ($parts[1] == 16) $netmask = '255.255.0.0';
        else if ($parts[1] == 17) $netmask = '255.255.128.0';
        else if ($parts[1] == 18) $netmask = '255.255.192.0';
        else if ($parts[1] == 19) $netmask = '255.255.224.0';
        else if ($parts[1] == 20) $netmask = '255.255.240.0';
        else if ($parts[1] == 21) $netmask = '255.255.248.0';
        else if ($parts[1] == 22) $netmask = '255.255.252.0';
        else if ($parts[1] == 23) $netmask = '255.255.254.0';
        else if ($parts[1] == 24) $netmask = '255.255.255.0';
        else if ($parts[1] == 25) $netmask = '255.255.255.128';
        else if ($parts[1] == 26) $netmask = '255.255.255.192';
        else if ($parts[1] == 27) $netmask = '255.255.255.224';
        else if ($parts[1] == 28) $netmask = '255.255.255.240';
        else if ($parts[1] == 29) $netmask = '255.255.255.248';
        else if ($parts[1] == 30) $netmask = '255.255.255.252';
        return [$parts[0], $netmask];
    }

    static public function getNetmask($netmask) {
        if ($netmask == '255.255.0.0') return 16;
        else if ($netmask == '255.255.128.0') return 17;
        else if ($netmask == '255.255.192.0') return 18;
        else if ($netmask == '255.255.224.0') return 19;
        else if ($netmask == '255.255.240.0') return 20;
        else if ($netmask == '255.255.248.0') return 21;
        else if ($netmask == '255.255.252.0') return 22;
        else if ($netmask == '255.255.254.0') return 23;
        else if ($netmask == '255.255.255.0') return 24;
        else if ($netmask == '255.255.255.128') return 25;
        else if ($netmask == '255.255.255.192') return 26;
        else if ($netmask == '255.255.255.224') return 27;
        else if ($netmask == '255.255.255.240') return 28;
        else if ($netmask == '255.255.255.248') return 29;
        else if ($netmask == '255.255.255.252') return 30;
        else return null;
    }

    static public function getConfig() {

        $content = self::getConfigContent();

        $content = array_map(function($line) { return trim($line); },explode("\n",str_replace("\t","",$content)));
        $static = false;
        $address = "";
        $netmask = "";
        $routers = "";
        $dns = "";
        foreach($content as $line) {
            if(strlen($line) ==0) continue;
            if(strcmp($line,"interface eth0") === 0) {
                $static = true;
            } else if($static and strlen($address) == 0 and stripos($line,"static ip_address=") === 0) {
                $address = substr($line,18);
            } else if($static and strlen($routers) == 0 and stripos($line,"static routers=") === 0) {
                $routers = substr($line,15);
            }  else if($static and strlen($dns) == 0 and stripos($line,"static domain_name_servers=") === 0) {
                $dns = substr($line,27);
            }
        }

        if (strlen($address) > 0) [$address, $netmask] = self::parseAddressIpWthNetmask($address);
        return ($static and strlen($address) > 0 and strlen($routers) > 0 and strlen($dns) > 0) ?
            ['type' => 'static', 'address_ip' => $address, 'netmask' => $netmask, 'gateway' => $routers, 'dns' => $dns] :
            ['type' => 'dhcp'];
    }



    static public function setStatic(string $address_ip, string $netmask, string $gateway, string $dns)
    {
        if (!filter_var($address_ip, FILTER_VALIDATE_IP)) return false;
        if (!filter_var($netmask, FILTER_VALIDATE_IP)) return false;
        if (!filter_var($gateway, FILTER_VALIDATE_IP)) return false;
        $dns = array_map(function($dns) { return filter_var($dns, FILTER_VALIDATE_IP) ? escapeshellarg($dns) : ''; }, explode(" ",str_replace(",", " ", $dns)));
        $dns = implode(' ', $dns);
        $netmask = self::getNetmask($netmask);
        if (!$netmask) $netmask = 24;
        $command = 'sudo '.(self::getBinaryPath()).' --static '.escapeshellarg($address_ip.'/'.$netmask).' '.escapeshellarg($gateway).' '.$dns;
        $process = new Process ($command);
        $process->run();
        return $process->isSuccessful() ? (bool)stristr($process->getOutput(), "ok") : false;
    }



    static public function setDHCP()
    {
        $command = 'sudo '.(self::getBinaryPath()).' --dhcp';
        $process = new Process ($command);
        $process->run();
        return $process->isSuccessful() ? (bool)stristr($process->getOutput(), 'ok') : false;
    }

    static public function reboot()
    {
        $command = 'sudo '.(self::getBinaryPath()).' --reboot';
        $process = new Process ($command);
        $process->run();
        return $process->isSuccessful() ? (bool)stristr($process->getOutput(), 'ok') : false;
    }

    static public function shutdown()
    {
        $command = 'sudo '.(self::getBinaryPath()).' --shutdown';
        $process = new Process ($command);
        $process->run();
        return $process->isSuccessful() ? (bool)stristr($process->getOutput(), 'ok') : false;
    }

    static public function update()
    {
        $command = 'sudo '.(self::getBinaryPath()).' --update';
        $process = new Process ($command);
        $process->run();
        return $process->isSuccessful() ? (bool)stristr($process->getOutput(), 'ok') : false;
    }
}

