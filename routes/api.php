<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Product Routes
Route::get('product', [ProductController::class, 'all']);
Route::get('product/{id}', [ProductController::class, 'detail']);

// Cart Routes
Route::get('cart/{id}', [CartController::class, 'all']);
Route::post('cart', [CartController::class, 'addToCart']);
Route::post('incTotalPesan/{id_cart}/{id_product}', [CartController::class, 'incTotalPesan']);
Route::post('decTotalPesan/{id_cart}/{id_product}', [CartController::class, 'decTotalPesan']);
Route::delete('remove/{id_cart}/{id_product}', [CartController::class, 'removeProductInCartItem']);
Route::delete('cart/{id}', [CartController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
