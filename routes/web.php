<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{shortCode}', [\App\Http\Controllers\UrlController::class, 'show']);
