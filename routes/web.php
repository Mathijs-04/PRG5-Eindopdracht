<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//Search:
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');

//Like
Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');

//Resource:
Route::resource('posts', PostController::class);

//Home
Route::get('/', [HomeController::class, 'index'])->name('home');

//Posts
Route::get('/posts', [PostController::class, 'index'])->name('posts');

//About
Route::get('/about', [AboutController::class, 'index'])->name('about');

//Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

//Show:
Route::get('/posts/{id}', [PostController::class, 'show'])->name('show');

//Edit:
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('edit');

//Store:
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

//Admin visibility toggle
Route::post('/posts/{post}/toggle-visibility', [AdminController::class, 'toggleVisibility'])->name('admin.posts.toggleVisibility');



//Default Laravel Welcome
Route::get('/welcome', function () {
    return view('welcome');
});

//Default Laravel Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Default Breeze Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
