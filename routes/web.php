<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');

    Route::post('/publish', 'RabbitMQController@publishMessage');
    Route::get('/consume', 'RabbitMQController@consumeMessage');
});
