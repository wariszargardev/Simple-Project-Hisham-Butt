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

Route::middleware(['api'])->group(function (){
    Route::prefix('/')->group(function (){
        Route::post('register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register']);
        Route::post('login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
        Route::post('forgot-password', [\App\Http\Controllers\Api\Auth\AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [\App\Http\Controllers\Api\Auth\AuthController::class, 'resetPassword']);
    });


    Route::middleware(['verify.token'])->group(function (){
        Route::prefix('/')->group(function (){
            Route::get('profile', [\App\Http\Controllers\Api\User\UserController::class, 'profile']);
            Route::post('update-profile', [\App\Http\Controllers\Api\User\UserController::class, 'updateProfile']);
        });
    });

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
