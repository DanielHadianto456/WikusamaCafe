<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

//API Route Collection for Authentication Taken from AuthController Controller
Route::middleware('auth:user_model')->group(function () {
    Route::controller(AuthController::class)->group(function (){
        Route::post('/auth/logout', 'logout');
    });
});

Route::controller(AuthController::class)->group(function (){
    Route::post('/auth/register', 'register');
    Route::post('/auth/login', 'login');
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:user_model');