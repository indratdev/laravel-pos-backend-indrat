<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\AuthController;
use \App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// post login api
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

// register
Route::post('/store', [\App\Http\Controllers\Api\AuthController::class, 'store']);

// logout
Route::post('logout',[\App\Http\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');

// api resource product
Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');


// Route::middleware('auth:sanctum')->get('/customers', function (Request $request) {
//     return $request->customers();
// });
