<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckIocToken;
use Illuminate\Support\Facades\Route;



// Rutas privadas USER
Route::middleware(CheckIocToken::class)->group(function () {
    
    Route::post('/users/logout', [UserController::class, 'logout']);    
    Route::patch('/users/me', [UserController::class, 'updateMe']);
    
});

// Rutas privadas ADMIN
Route::middleware(CheckAdmin::class)->group(function () {
    // Get all users
    Route::get('/users', [UserController::class, 'index']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::get('/roles', [RoleController::class, 'index']);
    
});

// Rutas publicas
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/login', [UserController::class, 'login']);
