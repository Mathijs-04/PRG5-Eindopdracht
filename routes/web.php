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

//Login-check
Route::get('/check', function () {
    return view('check');
})->middleware('auth');

//Resource:
Route::resource('posts', PostController::class);

//Routes:
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

// Show and Edit:
Route::get('/posts/{id}', [PostController::class, 'show'])->name('show');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('edit');

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
