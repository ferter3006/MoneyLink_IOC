<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckIocToken;
use Illuminate\Support\Facades\Route;


Route::get('/roles', [RoleController::class, 'index']);

// Private routes - Token Needed
Route::middleware(CheckIocToken::class)->group(function () {
    //  --------- USERS ------------
    // Logout
    Route::post('/users/logout', [UserController::class, 'logout']);
    // Update
    Route::patch('/users/me', [UserController::class, 'updateMe']);
    // Update
    Route::patch('/users/{id}', [UserController::class, 'update']);
    // Delete
    Route::delete('/users/{id}', [UserController::class, 'delete']);
    // Show
    Route::get('/users/{id}', [UserController::class, 'show']);
});

Route::middleware(CheckAdmin::class)->group(function () {
    // Get all users
    Route::get('/users', [UserController::class, 'index']);
    
});

// Crear usuario
Route::post('/users', [UserController::class, 'store']);
// Login
Route::post('/users/login', [UserController::class, 'login']);
