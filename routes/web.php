<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/redis-test', function () {
    // Acceder directamente a la clave 'desdeApp'
    Redis::setex('tokenid', 50, 'usuario'); // TTL 60 segundos
    return Redis::get('tokenid');
});

