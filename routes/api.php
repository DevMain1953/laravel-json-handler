<?php

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

//API route to register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route to make login for user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::post('/token', [App\Http\Controllers\API\TokenController::class, 'token']);

    // API route to make logout for user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});
