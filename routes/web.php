<?php

use App\Http\Controllers\InformeController;
use Illuminate\Support\Facades\Route;

/**
 * Rutas de la web ( no hay )
 */
Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/informe/{salaId}/{m}', [InformeController::class, 'informeSalaMes'])->name('informe.sala.mes');