<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return [
        'status' => '1',
        'message' => 'Estamos en la Home New Repo!',
        'version' => '10-06 1.0',
        'ultimos cambios' => 'Doc de swagger revisado'
    ];
});

Route::get('/redis-test', function () {
    // Acceder directamente a la clave 'desdeApp'
    Redis::setex('tokenid', 50, 'usuario'); // TTL 60 segundos
    return Redis::get('tokenid');
});

Route::get('/home', function () {
    // Devolver vista de bienvenida
    return view('test', ['name' => 'Ferter']);
});
