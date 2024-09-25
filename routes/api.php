<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartDataController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::controller(ProductsController::class)->prefix('products')->group(function () {
    Route::get('/',  'index');
    Route::post('/store',  'store')->middleware('auth:sanctum');
    Route::delete('/{id}',  'destroy')->middleware('auth:sanctum');
    Route::put('/{id}', 'update')->middleware('auth:sanctum');
    Route::get('/{id}', 'show');
});

Route::middleware('auth:sanctum')->prefix('cart')->group(function () {
    Route::get('/', [CartDataController::class, 'index']);
    Route::post('/add', [CartDataController::class, 'store']); 
    Route::put('/update/{id}', [CartDataController::class, 'update']); 
    Route::delete('/remove/{id}', [CartDataController::class, 'destroy']); 
});