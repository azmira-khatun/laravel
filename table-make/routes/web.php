<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OneToOneController;
use App\Http\Controllers\HasOneThroughController;

Route::get('/cars', [OneToOneController::class, 'show'])->name('cars.show');
// Hasonethrough route
Route::get('/hasone', [HasOneThroughController::class, 'index']);
Route::get('/hasone/{id}', [HasOneThroughController::class, 'show']);
