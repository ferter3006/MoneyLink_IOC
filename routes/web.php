<?php

use Illuminate\Support\Facades\Route;

/**
 * Rutas de la web ( no hay )
 */
Route::get('/', function () {
    return view('home');
})->name('home');


