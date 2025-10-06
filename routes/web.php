<?php


use Illuminate\Support\Facades\Route;


Route::get('/', function () {

    return [
        'status' => '1',
        'message' => 'Estamos en la Home New Repo!',
        'version' => '10-06 1.0',
        'ultimos cambios' => 'Doc de swagger revisado'
    ];
});
