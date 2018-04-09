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
        'button' => 'Change config'
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
    'sys-log' => '',

];