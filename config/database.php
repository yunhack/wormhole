<?php

return [

    'fetch' => PDO::FETCH_CLASS,

    'connections' => [

        'default' => [
            'driver' => 'mysql',
            'host' => '192.168.10.21',
            'database' => 'temple',
            'charset' => 'utf8',
            'username' => 'fserp',
            'password' => 'ayZpUHvVj03JtHF'
        ],

        'local' => [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'test',
            'charset' => 'utf8',
            'username' => 'root',
            'password' => ''
        ]

    ]
];
