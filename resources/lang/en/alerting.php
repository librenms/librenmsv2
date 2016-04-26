<?php

return [

    'general' => [
        'text' => [
            'rule'    => 'Rule',
            'state'   => 'State',
            'invalid' => 'Rule no longer exists',
        ],
    ],
    'alerts' => [
        'text' => [
            'id'           => 'Alert ID',
            'status'       => 'Status',
            'hostname'     => 'Hostname',
            'timestamp'    => 'Timestamp',
            'severity'     => 'Severity',
            'acknowledged' => 'Acknowledged',
            'noresults'    => 'No alerts - you run a tight ship :)',
        ],
    ],
    'logs' => [
        'text' => [
            'ok'     => 'Ok',
            'fail'   => 'Alert',
            'ack'    => 'Ack',
            'worse'  => 'Worse',
            'better' => 'Better',
        ],
    ],
    'stats' => [
        'text' => [
            'title'    => 'Alerting statistics',
        ],
        'btn'  => [
            'reset' => 'Reset',
        ],
    ],

];
