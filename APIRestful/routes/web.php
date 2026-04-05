<?php

use App\Http\Controllers\Categpry\CategoryController;
use App\Http\Controllers\HolaMundoController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Buyer\BuyerController; // 1. Importas el controlador

//Route::get('/', function () {return view('welcome');});


//asignacion de resource



Route::resource('buyers', BuyerController::class)->only(['index', 'show']);

/**
 * Categories (Todas excepto los formularios de creación/edición)
 */
Route::resource('categories', CategoryController::class)->except(['create', 'edit']);

/**
 * Products (Solo listar y ver uno)
 */
Route::resource('products', ProductController::class)->only(['index', 'show']);

/**
 * Transactions (Solo listar y ver uno)
 */
Route::resource('transactions', TransactionController::class)->only(['index', 'show']);

/**
 * Sellers (Solo listar y ver uno)
 */
Route::resource('sellers', SellerController::class)->only(['index', 'show']);

/**
 * Users (Todas excepto los formularios de creación/edición)
 */
Route::resource('users', UserController::class)->except(['create', 'edit']);
