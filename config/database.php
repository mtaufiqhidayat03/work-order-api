<?php
return  [
    'default' => 'mongodb',
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'database'  => env('DB_DATABASE', ''),
            'username'  => env('DB_USERNAME', ''),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],

        'mongodb' => array(
            'driver'   => 'mongodb',
            'host'     => env('MONGODB_HOST', 'localhost'),
            'port'     => env('MONGODB_PORT', 27017),
            'username' => env('MONGODB_USERNAME', 'taufik'),
            'password' => env('MONGODB_PASSWORD', 'taufik03'),
            'database' => env('MONGODB_DATABASE', 'mainsystem'),
            'options' => array(
                'db' => env('MONGODB_AUTHDATABASE', 'admin')
            )
        ),
    ],
];
