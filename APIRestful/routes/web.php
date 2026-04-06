<?php

use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Categpry\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Buyer\BuyerController; // 1. Importas el controlador

use App\Http\Controllers\Transaction\TransactionCategoryController;

use App\Http\Controllers\Transaction\TransactionSellerController;


//Route::get('/', function () {return view('welcome');});


//asignacion de resource



Route::resource('buyers', BuyerController::class)->only(['index', 'show']);
Route::resource('buyers.sellers', BuyerSellerController::class)->only(['index']);
Route::resource('buyers.transactions', BuyerTransactionController::class)->only(['index']);
Route::resource('buyers.products', BuyerProductController::class)->only(['index']);
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
Route::resource('transactions.categories', TransactionCategoryController::class)->only(['index']);
Route::resource('transactions.sellers', TransactionSellerController::class)->only(['index']);

Route::resource('sellers', SellerController::class)->only(['index', 'show']);


Route::resource('users', UserController::class);//->except(['create', 'edit']);
