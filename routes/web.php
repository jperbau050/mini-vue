<?php

use Illuminate\Support\Facades\Route;

// Esta es la ruta que te falta
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');