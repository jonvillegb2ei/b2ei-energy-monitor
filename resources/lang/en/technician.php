<?php

return [
    'title' => 'Technician',
    /*
    |--------------------------------------------------------------------------
    | Technician Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in the layout to display some
    | messages to user.
    |
    */
    // trans('technician.equipment-create.title')
    'equipment-create' => [
        'title' => 'Add an equipment',
        'type' => ['name' => 'Type', 'help' => 'Put a valid equipment type'],
        'name' => ['name' => 'Name', 'help' => 'Put a valid equipment name'],
        'ip-address' => ['name' => 'Address IP', 'help' => 'Put a valid IP V4 Address'],
        'port' => ['name' => 'Port', 'help' => 'Put a valid TCP port'],
        'slave' => ['name' => 'Slave ID', 'help' => 'Put a valid slave identifier'],
        'localisation' => ['name' => 'Localisation', 'help' => 'Put equipment localisation'],
        'button' => 'Create',
        'error' => 'Error during equipment creation.',
        'success' => 'Equipment created with success.',
    ],


    // trans('technician.ping.error')
    'ping' => [
        'title' => 'Ping device',
        'ip-address' => ['name' => 'Address IP', 'help' => 'Put a valid IP V4 Address'],
        'button' => 'Ping',
        'error' => 'Error during ping.',
        'success' => 'Device reply with a pong.',
    ],


    // trans('technician.identify.error')
    'identify' => [
        'title' => 'Identify device',
        'ip-address' => ['name' => 'Address IP', 'help' => 'Put a valid IP V4 Address'],
        'port' => ['name' => 'Port', 'help' => 'Put a valid TCP port'],
        'slave' => ['name' => 'Slave ID', 'help' => 'Put a valid slave identifier'],
        'mei-type' => ['name' => 'MEI type', 'help' => 'Put a valid MEI type'],
        'device-id' => ['name' => 'Device ID', 'help' => 'Put a valid device ID'],
        'button' => 'Identify',
        'error' => 'Can\'t identify device..',
        'success' => 'Device reply with identification data.',
    ],

    // trans('technician.modbus-client.data-length')
    // {{trans('technician.modbus-client.ip-address.name')}}
    'modbus-client' => [
        'title' => 'Modbus client',
        'ip-address' => ['name' => 'Address IP', 'help' => 'Put a valid IP V4 Address'],
        'port' => ['name' => 'Port', 'help' => 'Put a valid TCP port'],
        'slave' => ['name' => 'Slave ID', 'help' => 'Put a valid slave identifier'],
        'register' => ['name' => 'Register', 'help' => 'Put a valid register'],
        'length' => ['name' => 'Length', 'help' => 'Put a valid length'],
        'button' => 'Read registers',
        'error' => 'Can\'t read registers.',
        'unknown-error' => 'Unknown error.',
        'success' => 'Device reply with data.',
        'data-length' => 'Data length: ',
    ],

    'info' => [
        'picture' => 'Equipment picture',
        'brand' => 'Product brand',
        'reference' => 'Product reference',
        'ip-address' => 'Address Ip',
        'slave' => 'Slave id',
        'remove-question' => 'Do you really want to remove this equipment and all data associated ?',
        'remove-button' => 'Remove this equipment*',
        'remove-help' => ' * This action will remove equipment and all data associated.',
    ],

    // {{trans('technician.table.name')}}
    'table' => [
        'id' => '#',
        'name' => 'Name',
        'localisation' => 'Localisation',
        'brand' => 'Brand',
        'reference' => 'Reference',
        'ip-address' => 'Address IP',
        'slave' => 'Slave',
        'action' => [
            'title' => 'Action',
            'ping' => 'Ping device IP',
            'test' => 'Test equipment',
            'advanced' => 'Advanced parameters',
        ],

    ],


    // {{trans('technician.variable.id')}}
    'variable' => [
        'title' => 'Variables',
        'id' => '#',
        'name' => 'Name',
        'value' => 'Value',
        'unit' => 'Unit',
        'last-update' => 'Last update',
        'Log-interval' => 'Log interval',
        'Log-expiration' => 'Log expiration',
        'minute' => 'min',
        'button-help' => 'Change',
        'error' => 'Can\'t edit variable.',
        'success' => 'Variable edited.',
    ],


    // {{trans('technician.equipment-edit.title')}}
    'equipment-edit' => [
        'title' => 'Parameters',
        'name' => ['name' => 'Name', 'help' => 'Put a valid equipment name'],
        'ip-address' => ['name' => 'Address IP', 'help' => 'Put a valid IP V4 Address'],
        'port' => ['name' => 'Port', 'help' => 'Put a valid TCP port'],
        'slave' => ['name' => 'Slave ID', 'help' => 'Put a valid slave identifier'],
        'localisation' => ['name' => 'Localisation', 'help' => 'Put equipment localisation'],
        'button' => 'Edit',
        'error' => 'Error during equipment update.',
        'success' => 'Equipment edited with success.',
    ],

    // {{trans('technician.remove-success')}}
    'remove-success' => 'Equipment removed with success.',
    'remove-error' => 'Error during equipment deletion.',

    'test-success' => 'Test output : ',
    'test-error' => 'Error during equipment test.',



    'app-log' => 'Application logs',
    'sys-log' => 'System logs',

    // {{trans('technician.system-log-error')}}
    'app-log-error' => 'Error while parsing application logs.',
    'system-log-error' => 'Error while parsing system logs.',
    'dmesg-log-error' => 'Error while parsing DMESG logs.',

];