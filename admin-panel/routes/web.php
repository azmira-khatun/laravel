<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\PurchaseReturnController;



Route::get('/', function () {
    return view('portal');
});
Route::get('/master', function () {
    return view('master');
});
Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboardCard');
});
// ===================================
// 1. User Management Routes
// ===================================
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/add-user', [UserController::class, 'create'])->name('userCreate');
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


Route::get('/product_units', [ProductUnitController::class, 'index'])->name('productUnitIndex');
Route::get('/product_units/create', [ProductUnitController::class, 'create'])->name('productUnitCreate');
Route::post('/product_units', [ProductUnitController::class, 'store'])->name('productUnitStore');
Route::get('/product_units/{unit}/edit', [ProductUnitController::class, 'edit'])->name('productUnitEdit');
Route::put('/product_units/{unit}', [ProductUnitController::class, 'update'])->name('productUnitUpdate');
Route::delete('/product_units/{unit}', [ProductUnitController::class, 'destroy'])->name('productUnitDelete');





// product start


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
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


// 🧾 Purchases Routes
Route::get('/purchases/history', [PurchaseController::class, 'history'])->name('purchasesHistory');
Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchasesCreate');
Route::post('/purchases/store', [PurchaseController::class, 'store'])->name('purchasesStore');
Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchasesShow');
Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchasesEdit');
Route::put('/purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchasesUpdate');
Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchasesDelete');




Route::get('/purchase-items/history', [PurchaseItemController::class, 'history'])->name('purchaseItems.history');
Route::get('/purchase-items/create',  [PurchaseItemController::class, 'create'])->name('purchaseItems.create');
Route::post('/purchase-items/store',  [PurchaseItemController::class, 'store'])->name('purchaseItems.store');
Route::get('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'show'])->name('purchaseItems.show');
Route::get('/purchase-items/{purchaseItem}/edit', [PurchaseItemController::class, 'edit'])->name('purchaseItems.edit');
Route::put('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'update'])->name('purchaseItems.update');
Route::delete('/purchase-items/{purchaseItem}', [PurchaseItemController::class, 'destroy'])->name('purchaseItems.delete');





Route::get('/purchase‑returns', [PurchaseReturnController::class, 'index'])->name('purchase_returns.index');
Route::get('/purchase‑returns/create', [PurchaseReturnController::class, 'create'])->name('purchase_returns.create');
Route::post('/purchase‑returns', [PurchaseReturnController::class, 'store'])->name('purchase_returns.store');
Route::get('/purchase‑returns/{purchaseReturn}', [PurchaseReturnController::class, 'show'])->name('purchase_returns.show');
Route::get('/purchase‑returns/{purchaseReturn}/edit', [PurchaseReturnController::class, 'edit'])->name('purchase_returns.edit');
Route::put('/purchase‑returns/{purchaseReturn}', [PurchaseReturnController::class, 'update'])->name('purchase_returns.update');
Route::delete('/purchase‑returns/{purchaseReturn}', [PurchaseReturnController::class, 'destroy'])->name('purchase_returns.destroy');

// AJAX route to fetch purchase data
Route::post('/purchase‑returns/fetch‑purchase‑data', [PurchaseReturnController::class, 'fetchPurchaseData'])->name('purchase_returns.fetch_purchase_data');
