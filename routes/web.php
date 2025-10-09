<?php

use App\Http\Controllers\Web\UserController;
<<<<<<< HEAD
use App\Models\User;
=======
>>>>>>> 390b57e326450b19e5b32ab6d2a42cf90fb5fd41
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

<<<<<<< HEAD
;
=======
Route::get('/users', [UserController::class, 'index']);
>>>>>>> 390b57e326450b19e5b32ab6d2a42cf90fb5fd41
