<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderDetailController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */
Route::apiResource('clients', ClientController::class);

Route::apiResource('books', BookController::class);

//Route::apiResource('orders', OrderController::class);

Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::post('orders', [OrderController::class, 'store']);
Route::put('orders/{id}', [OrderController::class, 'update']);
Route::delete('orders/{id}', [OrderController::class, 'destroy']);
Route::post('orders/{id}/add-book', [OrderController::class, 'addBookToOrder']);
Route::post('orders/{id}/checkout', [OrderController::class, 'checkout']);
Route::put('orders/{orderId}/books/{bookId}', [OrderController::class, 'updateBookQuantity']);
Route::delete('orders/{orderId}/books/{bookId}', [OrderController::class, 'removeBookFromOrder']);

Route::apiResource('order-details', OrderDetailController::class);

//Route::post('orders/{order}/checkout', [OrderController::class, 'checkout']);
