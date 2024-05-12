<?php

return [
    'host' => env('RABBITMQ_HOST'),
    'vhost' => env('RABBITMQ_VHOST'),
    'port' => env('RABBITMQ_PORT'),
    'user' => env('RABBITMQ_USER'),
    'password' => env('RABBITMQ_PASSWORD'),
    'options' => [
        'heartbeat' => 60,
        'connection_timeout' => 10, // Set connection timeout in seconds
        'read_write_timeout' => 60 * 2, // Set read/write timeout in seconds
        'channel_rpc_timeout' => 60 * 2, // Set RPC timeout in seconds
    ],
];
