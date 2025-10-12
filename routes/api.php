<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\TiquetController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckIocToken;
use Illuminate\Support\Facades\Route;


// Rutas privadas USER
Route::middleware(CheckIocToken::class)->group(function () {

    Route::post('/users/logout', [UserController::class, 'logout']);
    Route::patch('/users/me', [UserController::class, 'updateMe']);

    // Salas
    Route::get('/salas/me', [SalaController::class, 'index']);
    Route::post('salas', [SalaController::class, 'store']);
    Route::patch('salas/{id}', [SalaController::class, 'update']);
    Route::delete('salas/{id}', [SalaController::class, 'delete']);
    Route::get('salas/{id}/{m}', [SalaController::class, 'show']);

    // Tiquets
    Route::post('tiquets', [TiquetController::class, 'create']);
    Route::patch('tiquets/{id}', [TiquetController::class, 'update']);
    Route::delete('tiquets/{id}', [TiquetController::class, 'delete']);


    // Categorias
    Route::get('categories', [CategoryController::class, 'index']);
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

