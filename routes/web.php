<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\AuthController as AdminAuthController;
use App\Http\Controllers\admin\MovieController as AdminMovieController;
use App\Http\Controllers\admin\EpisodeController as AdminEpisodeController;
use App\Http\Controllers\admin\GenreController as AdminGenreController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;

// user routes
Route::get("/", [MovieController::class, 'listMovies'])->name('home');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('register', action: [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix("movie")->group(function () {
    Route::get("list", [MovieController::class, 'listMovies'])->name('movie.list');
    Route::get("{slug}", [MovieController::class, 'detailMovie'])->name('movie.detail');
});

Route::prefix("uploads")->group(function () {
    Route::get("playlist/{folder}/{playlist}", [MovieController::class, 'getMovie'])->name('movie.playlist');
    Route::get("media/{folder}/{media}", [MovieController::class, 'getFile'])->name('movie.media');
    Route::get("key/{folder}/{key}", [MovieController::class, 'getKey'])->name('movie.key');
});

// admin routes
Route::get('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'loginPost'])->name('login.post');

Route::prefix("admin")->middleware("auth.admin")->group(function () {
    Route::get("", [DashboardController::class, 'index'])->name('admin.home');
    Route::get("dashboard", [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::resource('genre', AdminGenreController::class);
    Route::resource('movie', AdminMovieController::class);
    Route::resource('episode', AdminEpisodeController::class);
});


