<?php

use App\Http\Controllers\Inspection\CekMobilController;
use App\Http\Controllers\MasterData\CategoryController;
use App\Http\Controllers\MasterData\InspectionPointController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/categories', CategoryController::class);
    Route::resource('/inspection-points', InspectionPointController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('/cek-mobil', CekMobilController::class);
});