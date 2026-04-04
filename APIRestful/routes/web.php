<?php

use App\Http\Controllers\HolaMundoController;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/hola', [HolaMundoController::class, 'saludar']);
