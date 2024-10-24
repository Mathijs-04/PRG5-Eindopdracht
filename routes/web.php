<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Laravel Welcome
Route::get('/welcome', function () {
    return view('welcome');
});

//Search:
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');

//Resource:
Route::resource('posts', PostController::class);

//Pages:
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

// Show:
Route::get('/posts/{id}', [PostController::class, 'show'])->name('show');

//Edit:
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('edit');

//Store:
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

//Admin visibility toggle
Route::post('/posts/{post}/toggle-visibility', [AdminController::class, 'toggleVisibility'])->name('admin.posts.toggleVisibility');

//Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
