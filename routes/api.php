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

    // Usuario
    Route::post('/users/logout', [UserController::class, 'logout']);    // Logout de usuario
    Route::patch('/users/me', [UserController::class, 'updateMe']);     // Update de usuario
    Route::delete('/users/me', [UserController::class, 'deleteMe']);    // Delete de usuario
    

    // Salas
    Route::get('/salas/me', [SalaController::class, 'index']);          // Lista las salas de un usuario
    Route::post('salas', [SalaController::class, 'store']);             // Crea una sala
    Route::patch('salas/{id}', [SalaController::class, 'update']);      // Actualiza una sala
    Route::delete('salas/{id}', [SalaController::class, 'delete']);     // Elimina una sala
    Route::get('salas/{id}/{m}', [SalaController::class, 'show']);      // Muestra el estado de la sala en un mes concreto

    // Tiquets
    Route::post('tiquets', [TiquetController::class, 'create']);        // Crea un tiquet
    Route::patch('tiquets/{id}', [TiquetController::class, 'update']);  // Actualiza un tiquet
    Route::delete('tiquets/{id}', [TiquetController::class, 'delete']); // Elimina un tiquet
    Route::get('tiquets/{id}', [TiquetController::class, 'show']);      // Muestra un tiquet

    // Categorias
    Route::get('categories', [CategoryController::class, 'index']);     // Lista las categorias

});

// Rutas privadas ADMIN
Route::middleware(CheckAdmin::class)->group(function () {
    
    // Usuarios
    Route::get('/users', [UserController::class, 'index']);
    Route::patch('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    
    // Roles
    Route::get('/roles', [RoleController::class, 'index']);

});

// Rutas publicas
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/login', [UserController::class, 'login']);
