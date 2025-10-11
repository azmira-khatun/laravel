<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('master');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/add-user', [UserController::class, 'index']);
Route::get('/userCreate', [UserController::class, 'create'])->name('userCreate');

Route::post('userStore', [UserController::class, 'store'])->name('userStore');
Route::get('userEdit/{user_id}', [UserController::class, 'update'])->name('userEdit');

Route::post('editStoreU', [UserController::class, 'editStoreU'])->name('editStoreU');

Route::delete('delete', [UserController::class, 'destroy'])->name('delete');
