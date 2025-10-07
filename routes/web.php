<?php

use App\Events\StatusUpdated;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    return [
        'status' => '1',
        'message' => 'Estamos en la Home New Repo!',
        'version' => '10-06 1.0',
        'ultimos cambios' => 'Doc de swagger revisado'
    ];
});

Route::get('/status', function () {
    return view('status');
});


Route::post('/update-status', function () {
    $message = 'Actualizado: ' . now()->format('H:i:s');
    broadcast(new StatusUpdated($message));
    return response()->json(['ok' => true, 'message' => $message]);
});