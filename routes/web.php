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