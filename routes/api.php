<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvitacionController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\TiquetController;
use App\Http\Controllers\TiquetRecurrenteController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckIocToken;
use Illuminate\Support\Facades\Route;

/**
 * Rutas privadas y publicas de la API
 * @author Lluís Ferrater
 * @version 1.0 
 */

//---------------- Rutas privadas USER ------------------
Route::middleware(CheckIocToken::class)->group(function () {
    // Test
    Route::get('/test', [SalaController::class, 'test']);                     // Test de ruta privada

    // Usuario
    Route::post('/users/logout', [UserController::class, 'logout']);        // Logout de usuario
    Route::patch('/users/me', [UserController::class, 'updateMe']);         // Update de usuario
    Route::delete('/users/me', [UserController::class, 'deleteMe']);        // Delete de usuario    

    // Salas    
    Route::get('/salas/me', [SalaController::class, 'indexMe']);              // Lista las salas de un usuario
    Route::post('salas', [SalaController::class, 'store']);                 // Crea una sala
    Route::post('salas/with_invitations', [SalaController::class, 'storeWithInvitations']); // Crea una sala con invitaciones
    Route::patch('salas/{id}', [SalaController::class, 'update']);          // Actualiza una sala
    Route::delete('salas/{id}', [SalaController::class, 'delete']);         // Elimina una sala
    Route::get('salas/{id}/{m}', [SalaController::class, 'show']);          // Muestra el estado de la sala en un mes concreto
    Route::patch('/salas/{id}/users/{userId}', [SalaController::class, 'updateUserRole']); // Actualiza el rol de un usuario en una sala
    Route::delete('/salas/{id}/users/{userId}', [SalaController::class, 'deleteUserFromSala']); // Elimina a un usuario de una sala

    // Tiquets  
    Route::post('tiquets', [TiquetController::class, 'store']);             // Crea un tiquet
    Route::patch('tiquets/{id}', [TiquetController::class, 'update']);      // Actualiza un tiquet
    Route::delete('tiquets/{id}', [TiquetController::class, 'delete']);     // Elimina un tiquet
    Route::get('tiquets/{id}', [TiquetController::class, 'show']);          // Muestra un tiquet

    // Tiquets recurrentes
    Route::post('tiquets/rr', [TiquetRecurrenteController::class, 'store']);          // Crea un tiquet recurrente
    Route::patch('tiquets/rr/{id}', [TiquetRecurrenteController::class, 'update']);   // Actualiza un tiquet recurrente
    Route::delete('tiquets/rr/{id}', [TiquetRecurrenteController::class, 'delete']);  // Elimina un tiquet recurrente

    // Categorias
    Route::get('categories', [CategoryController::class, 'index']);             // Lista las categorias

    // Invitaciones
    Route::get('/invitaciones/recibidas', [InvitacionController::class, 'index_recibidas']);        // Lista las invitaciones recibidas por el usuario
    Route::get('/invitaciones/enviadas', [InvitacionController::class, 'index_enviadas']);          // Lista las invitaciones enviadas por el usuario
    Route::post('/invitaciones', [InvitacionController::class, 'create']);                          // Crea una invitacion
    Route::post('/invitaciones/{id}', [InvitacionController::class, 'responder']);                  // Responde a una invitacion
    Route::delete('/invitaciones/{id}', [InvitacionController::class, 'destroy']);                  // Elimina una invitacion

    // Stats
    Route::get('/stats/salas/{salaId}/{m}', [StatsController::class, 'general']);   // Estadisticas generales de una sala


});

//------------------ Rutas privadas ADMIN ------------------
Route::middleware(CheckAdmin::class)->group(function () {

    // Usuarios
    Route::get('/users', [UserController::class, 'index']);                     // Lista los usuarios
    Route::patch('/users/{id}', [UserController::class, 'update']);             // Actualiza un usuario
    Route::delete('/users/{id}', [UserController::class, 'delete']);            // Elimina un usuario
    Route::get('/users/{id}', [UserController::class, 'show']);                 // Muestra un usuario

    // Roles
    Route::get('/roles', [RoleController::class, 'index']);                     // Lista los roles    

    // Categorias
    Route::post('categories', [CategoryController::class, 'store']);            // Crea una categoria
    Route::patch('categories/{id}', [CategoryController::class, 'update']);     // Actualiza una categoria
    Route::delete('categories/{id}', [CategoryController::class, 'delete']);    // Elimina una categoria

});

// Rutas publicas
Route::post('/users', [UserController::class, 'store']);                    // Crea un usuario
Route::post('/users/login', [UserController::class, 'login']);              // Login de usuario
