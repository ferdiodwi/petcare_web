<?php

use App\Livewire\BlogPosts;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;


Route::get('/users', [UserController::class, 'index']);

Route::get('/services', \App\Livewire\ServicesList::class)->name('services');
Route::get('/blog', \App\Livewire\Blog::class)->name('blog');
Route::get('/blog/{slug}', \App\Livewire\BlogShow::class)->name('blog.show');
Route::get('/about', \App\Livewire\About::class)->name('about');

// Redirect root to blog page
Route::redirect('/', '/home');

// Blog routes - accessible without login
Route::get('/home', Home::class)->name('home.index');

// Auth routes (handled by Jetstream)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    // User dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin routes (will be handled by Filament)
});


Route::get('/consultation', \App\Livewire\Consultation::class)->name('consultation');
