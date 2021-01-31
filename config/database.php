<?php
return  [
    'default' => 'mongodb',
    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST'),
            'database'  => env('DB_DATABASE'),
            'username'  => env('DB_USERNAME'),
            'password'  => env('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
        'mongodb' => array(
            'driver'   => 'mongodb',
            'host'     => env('MONGODB_HOST'),
            'port'     => env('MONGODB_PORT'),
            'username' => env('MONGODB_USERNAME'),
            'password' => env('MONGODB_PASSWORD'),
            'database' => env('MONGODB_DATABASE'),
            'options' => array(
                'db' => env('MONGODB_AUTHDATABASE')
            )
        ),
    ],
];
