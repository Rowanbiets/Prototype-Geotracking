<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/location', [LocationController::class, 'store'])->middleware('auth');
Route::get('/track-location', function () {
    return view('track-location');
})->middleware('auth');
Route::get('/locations', [LocationController::class, 'index'])->middleware('auth:sanctum');
