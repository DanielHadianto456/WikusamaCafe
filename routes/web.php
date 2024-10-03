<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{pathMatch}', function() {
    return view('welcome');
})->where('pathMatch', '.*');

Route::get('generate-pdf', [App\Http\Controllers\pdfController::class, 'getPdf']);