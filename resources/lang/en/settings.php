<?php
return [
    'text' => [
        'readonly' => 'Read-Only: you do not have permissions to edit this setting.'
    ],
    'snmp' => [
        'title'      => 'SNMP Defaults',
        'tabs'       => [
            'common' => 'Common',
            'v3'     => 'v3',
        ],
        'version'    => 'Default Version',
        'community'  => 'Community',
        'port'       => 'Port',
        'transports' => 'Transport Order',
        'v3'         => [
            'authlevel'  => 'AuthLevel',
            'authname'   => 'AuthName',
            'authalgo'   => 'AuthAlgo',
            'authpass'   => 'AuthPass',
            'cryptoalgo' => 'CryptoAlgo',
            'cryptopass' => 'CryptoPass',
        ],
    ],
];