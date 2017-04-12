<?php

return [

    'text' => [
        'add'             => 'Add Device',
        'warning'         => 'Devices will be checked for Ping and SNMP reachability before being probed. Only devices with recognised OSes will be added.',
        'forceadd'        => 'Force add',
        'deleted'         =>  '&lt;deleted&gt;',
        'os'              => 'Operating system',
        'vendor'          => 'Vendor',
        'platform'        => 'Platform',
        'uptime_location' => 'Uptime/Location',
        'notes'           => 'Notes',
    ],
    'groups' => [
        'title'          => 'Device Groups',
        'name'           => 'Name',
        'desc'           => 'Description',
        'pattern'        => 'Pattern',
        'actions'        => 'Actions',
        'create'         => 'New Device Group',
        'updated'        => 'Device group <i>:name</i> updated.',
        'deleted'        => 'Device group <i>:name</i> deleted.',
        'deletefailed'   => 'Failed to delete device group <i>:name</i>',
        'created'        => 'Device group <i>:name</i> created.',
        'ruleloadfailed' => 'Failed to load the rule, parse failure.',
        'deleteconfirm'  => [
            'title'   => 'Delete Device Group?',
            'message' => 'Are you sure you want to delete this device group?',
        ],
    ],
    'label' => [
        'hostname'     => 'Hostname',
        'port'         => 'Port',
        'snmpver'      => 'SNMP Version',
        'portassoc'    => 'Port Association Mode',
        'v1v2c'        => 'SNMPv1/2c Configuration',
        'v3'           => 'SNMPv3 Configuration',
        'community'    => 'Community',
        'authlevel'    => 'Auth Level',
        'authname'     => 'Auth User Name',
        'authpass'     => 'Auth Password',
        'authalgo'     => 'Auth Algorithm',
        'cryptopass'   => 'Crypto Password',
        'cryptoalgo'   => 'Crypto Algorithm',
        'pollergroup'  => 'Poller Group',
    ],
    'btn' => [
        'add'   => 'Add Device',
    ]

];
