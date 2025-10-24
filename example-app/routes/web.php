<?php

use App\Http\Controllers\OneToOneController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OneToManyController;
use App\Http\Controllers\HasOneThroughController;
use App\Http\Controllers\HasManyThroughController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

// --- 1. Basic App Routes ---

Route::get('/', function () {
    return view('welcome');
});

// Home Page
Route::get('/h', function () {
    return view('home');
});

// Add User Page
Route::get('/add', function () {
    // Note: Removed extra spaces from view name 'pages.add-user'
    return view('pages.add-user');
});

// Manage User Page
Route::get('/manage', function () {
    // Note: Removed extra spaces from view name 'pages.manage-user'
    return view('pages.manage-user');
});

// Master Layout Test Page
Route::get('/master', function () {
    return view('master');
});
// --- 2. One-to-One Profile Management Routes ---
Route::get('/profile', [OneToOneController::class, 'show'])->name('profile.show');

Route::get('/profile/{id}/edit', [OneToOneController::class, 'edit'])->name('profile.edit');

Route::put('/profile/{id}', [OneToOneController::class, 'update'])->name('profile.update');




// OneToMany relation

Route::get('/documents', [OneToManyController::class, 'index'])->name('documents.index');

Route::get('/documents/{document}/edit', [OneToManyController::class, 'edit'])->name('documents.edit');

Route::put('/documents/{document}', [OneToManyController::class, 'update'])->name('documents.update');

// HasOneThrough relation
Route::get('/car', [HasOneThroughController::class, 'index']);

// HasManyThrough relation


Route::get('/deployments', [HasManyThroughController::class, 'index'])->name('deployments.index');

