<?php

use App\Http\Controllers\OneToOneController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostCommentController;
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







/// --- 2. One-to-One Profile Management Routes ---

// 1. প্রোফাইল তালিকা দেখানোর জন্য রুট (Index)
Route::get('/profile', [OneToOneController::class, 'show'])->name('profile.show');

// 2. প্রোফাইল তৈরির ফর্ম দেখানোর জন্য রুট (Create Form)
Route::get('/profile/create', [OneToOneController::class, 'create'])->name('profile.create');

// 3. **নতুন সংযোজন:** ফর্ম থেকে ডেটা সেভ করার জন্য রুট (Store)
Route::post('/profile', [OneToOneController::class, 'store'])->name('profile.store'); // **এটি যোগ করতে হবে**

// 4. একটি নির্দিষ্ট প্রোফাইল দেখার জন্য রুট (View/Show Singular)
Route::get('/profile/{id}', [OneToOneController::class, 'view'])->name('profile.view');

// 5. **নতুন সংযোজন:** প্রোফাইল এডিট করার ফর্ম দেখানোর জন্য রুট (Edit Form)
Route::get('/profile/{id}/edit', [OneToOneController::class, 'edit'])->name('profile.edit'); // **এটি যোগ করতে হবে**

// 6. ডেটা আপডেট করার জন্য রুট (Update)
Route::put('/profile/{id}', [OneToOneController::class, 'update'])->name('profile.update');

// 7. প্রোফাইল মুছে ফেলার জন্য রুট (Destroy)
Route::delete('/profile/{id}', [OneToOneController::class, 'destroy'])->name('profile.destroy');



// one to many

Route::get('/documents', [PostCommentController::class, 'index'])->name('documents.index');

Route::get('/comments', [PostCommentController::class, 'listComments'])->name('comments.index');

Route::get('/comments/{id}', [PostCommentController::class, 'show'])->name('comments.show');

Route::get('/', function () {
    return view('welcome');
});


// HasOneThrough relation
Route::get('/car', [HasOneThroughController::class, 'index']);

// HasManyThrough relation


Route::get('/deployments', [HasManyThroughController::class, 'index'])->name('deployments.index');

