<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckIocToken;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return [
        'status' => '1',
        'message' => 'Estamos en la Home'
    ];
});


