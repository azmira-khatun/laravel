<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;



Route::get('/', function () {
    return view('portal');
});
Route::get('/master', function () {
    return view('master');
});
Route::get('/users', [UserController::class, 'index'])->name('user.index'); // New path: /users
Route::get('/add-user', [UserController::class, 'create'])->name('userCreate'); // Let /add-user be the actual creation form
Route::post('userStore', [UserController::class, 'store'])->name('userStore');
Route::get('userEdit/{user_id}', [UserController::class, 'update'])->name('userEdit');
Route::post('editStoreU', [UserController::class, 'editStoreU'])->name('editStoreU');
Route::delete('delete', [UserController::class, 'destroy'])->name('delete');

// ctaegory

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

// vendor start




Route::get('/vendors', [VendorController::class, 'index'])->name('vendorIndex');
Route::get('/vendors/create', [VendorController::class, 'create'])->name('vendorCreate');
Route::post('/vendors', [VendorController::class, 'store'])->name('vendorStore');
Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->name('vendorShow');
Route::get('/vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendorEdit');
Route::put('/vendors/{vendor}', [VendorController::class, 'update'])->name('vendorUpdate');
Route::delete('/vendors/{vendor}', [VendorController::class, 'destroy'])->name('vendorDelete');

// Customer CRUD Routes
Route::get('/customers', [CustomerController::class, 'index'])->name('customerIndex');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customerCreate');
Route::post('/customers', [CustomerController::class, 'store'])->name('customerStore');
Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customerShow');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customerEdit');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customerUpdate');
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customerDelete');
