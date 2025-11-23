<?php

use App\Http\Controllers\InformeController;
use App\Http\Middleware\CheckIocToken;
use App\Http\Middleware\IsSalaAdminMiddleware;
use Illuminate\Support\Facades\Route;

/**
 * Rutas de la web ( no hay )
 */
Route::get('/', function () {
    return view('home');
})->name('home');

$protectRoute = true;

$middlewares = $protectRoute
    ? [CheckIocToken::class, IsSalaAdminMiddleware::class]
    : [];

Route::get('/informe/{salaId}/{m}', [InformeController::class, 'informeSalaMes'])
    ->name('informe.sala.mes')
    ->middleware($middlewares);