<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OneToOneController;

Route::get('/cars', [OneToOneController::class, 'show'])->name('cars.show');
