<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;


Route::post('/location', [LocationController::class, 'store'])->name('location.store');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/track-location', function () {
    return view('track-location');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('login', [LoginController::class, 'showLoginForm'])->middleware('guest');
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth');


Route::post('/location', [LocationController::class, 'store'])->name('location.store');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
