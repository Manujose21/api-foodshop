<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::delete('/order/{order:id}', [OrderController::class, 'delete']);
    Route::post('/proccess_order/{order:id}', [OrderController::class, 'complete']);

    Route::get('/orders/all', [OrderController::class, 'getAllOrders']);

    Route::get('/users', [UserController::class, 'index']);
    Route::delete('/user/{user:id}', [UserController::class, 'delete']);

    
});

Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/products', ProductController::class);

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->name('verification.verify');

Route::post('/email/resend', [AuthController::class, 'resendVerifyEmail'])
    ->name('verification.resend')->middleware('auth:sanctum');