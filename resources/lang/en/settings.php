<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Settings Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in the layout to display some
    | messages to user.
    |
    */
    // trans('settings.dhcp-enable')
    'ip-config' => [
        'title' => 'IP configuration',
        'actual' => 'Actual',
        'dhcp' => 'DHCP',
        'static' => 'STATIC IP',
        'mac-address' => 'MAC address',
        'ip-address' => [
            'name' => 'IP address',
            'help' => 'Set a valid IPV4 address like 169.254.0.1',
        ],
        'netmask' => [
            'name' => 'Met mask',
            'help' => 'Set a valid IPV4 netmask like 255.255.0.0',
        ],
        'gateway' => [
            'name' => 'Gateway',
            'help' => 'Set a valid IPV4 gateway address like 169.254.0.254',
        ],
        'dns' => [
            'name' => 'DNS',
            'help' => 'Set a valid IPV4 DNS server address separated with spaces like 169.254.0.254 8.8.8.8 8.8.4.4',
        ],
        'button' => 'Change config',


        'static-enable' => 'Network is now in static mode.',
        'dhcp-enable' => 'Network is now in DHCP mode with a fallback ip as 192.168.0.2 (netmask: 255.255.255.0).',
        'error' => 'Error while changing network configuration.',
        'config-error' => 'Error while changing network configuration. Verify your configuration (only IPV4 are supported for the moment).',
        'action-error' => 'Unknown action provided.',

        'shutdown-success' => 'System is going to shutdown.',
        'shutdown-error' => 'Error while trying to shutdown device. Try to manually power off the device to recover your system.',

        'reboot-success' => 'System is going to reboot.',
        'reboot-error' => 'Error while trying to reboot device. Try to manually power off and power on the device to recover your system.',

        'update-success' => 'System will be updating on the next boot.',
        'update-error' => 'Error while trying to create require-update file.',

    ],


    'backup' => [
        'title' => 'Backup',
        'create-download' => 'Create and download a backup.*',
        'take-a-while' => '*It can take a while.',
    ],


    'system' => [
        'title' => 'Update and system',
        'shutdown' => 'Shutdown',
        'reboot' => 'Reboot',
        'application' => 'Application',
        'update' => 'Update application files',
        'reset' => 'Reset to factory settings',
    ],

    'app-log' => 'Application logs',
    'sys-log' => 'System logs',

];