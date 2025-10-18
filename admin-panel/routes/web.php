<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('master');
});

Route::get('/add-user', [UserController::class, 'index']);
Route::get('/userCreate', [UserController::class, 'create'])->name('userCreate');

Route::post('userStore', [UserController::class, 'store'])->name('userStore');
Route::get('userEdit/{user_id}', [UserController::class, 'update'])->name('userEdit');

Route::post('editStoreU', [UserController::class, 'editStoreU'])->name('editStoreU');

Route::delete('delete', [UserController::class, 'destroy'])->name('delete');
// category route


Route::get('/add-category', [CategoryController::class, 'index']);
Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{category_id}', [CategoryController::class, 'update'])->name('category.edit');
Route::post('/category/editStore', [CategoryController::class, 'editStore'])->name('category.editStore');
Route::delete('/category/delete', [CategoryController::class, 'destroy'])->name('category.delete');





// product start



Route::get('/products', [ProductController::class, 'index'])->name('productIndex');
Route::get('/products/create', [ProductController::class, 'create'])->name('productCreate');
Route::post('/products', [ProductController::class, 'store'])->name('productStore');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('productEdit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('productUpdate');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('productDelete');
