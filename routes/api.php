<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Admin\FoodController;

//API Route Collection for Authentication Taken from AuthController Controller
Route::middleware('auth:user_model')->group(function () {

    Route::controller(AuthController::class)->group(function (){
        Route::post('/auth/logout', 'logout');
    });

    //Admin API
    Route::controller(FoodController::class)->group(function (){
        Route::get('/admin/food/get', 'getFood');
        Route::get('/admin/food/getId/{id}', 'getFoodId');
        Route::post('/admin/food/add', 'addFood');
        Route::patch('/admin/food/update/{id}', 'updateFood');
        Route::delete('/admin/food/delete/{id}', 'deleteFood');
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