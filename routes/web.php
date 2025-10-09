<?php

use App\Http\Controllers\Web\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/redis-test', function () {
    // Acceder directamente a la clave 'desdeApp'
    Redis::setex('tokenid', 50, 'usuario'); // TTL 60 segundos
    return Redis::get('tokenid');
});

Route::post('/user/login', [UserController::class, 'login']);

Route::get('/user/dashboard', function () {
    $user = User::find(2);
    return view('dashboard', compact('user'));
});

;
