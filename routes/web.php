<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');
Route::get("/", [MovieController::class, 'listMovies'])->name('home');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('register', action: [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get("list", [MovieController::class, 'listMovies'])->name('movie.list');
Route::get("{slug}", [MovieController::class, 'detailMovie'])->name('movie.detail');

Route::prefix("uploads")->group(function () {
    Route::get("playlist/{folder}/{playlist}", [MovieController::class, 'getMovie'])->name('movie.playlist');
    Route::get("media/{folder}/{media}", [MovieController::class, 'getFile'])->name('movie.media');
    Route::get("key/{folder}/{key}", [MovieController::class, 'getKey'])->name('movie.key');
});
