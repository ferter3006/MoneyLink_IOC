<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckIocToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/roles', [RoleController::class, 'index']);
// USERS
Route::get('/users', [UserController::class, 'index'])->middleware(CheckIocToken::class);
// Crear usuario
Route::post('/users', [UserController::class, 'store']);
// Login
Route::post('/users/login', [UserController::class, 'login']);
// Logout
Route::post('/users/logout', [UserController::class, 'logout']);
