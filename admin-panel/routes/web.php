<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('master');
});

Route::get('/home', [HomeController::class, 'index']);
