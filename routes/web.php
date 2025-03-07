<?php

use App\Http\Controllers\DataMobil\BrandController;
use App\Http\Controllers\DataMobil\CarsController;
use App\Http\Controllers\DataMobil\CarTypeController;
use App\Http\Controllers\DataMobil\EngineCapacityController;
use App\Http\Controllers\DataMobil\FuelTypeController;
use App\Http\Controllers\DataMobil\ModelController;
use App\Http\Controllers\DataMobil\ProductionPeriodController;
use App\Http\Controllers\DataMobil\TransmissionController;
use App\Http\Controllers\Inspection\CekMobilController;
use App\Http\Controllers\Inspection\DetailKendaraanController;
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
    Route::resource('/detail-kendaraan', DetailKendaraanController::class);
    Route::resource('/cek-mobil', CekMobilController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('/data-mobil/brand', BrandController::class);
    Route::resource('/data-mobil/model', ModelController::class);
    Route::resource('/data-mobil/car-type', CarTypeController::class);
    Route::resource('/data-mobil/capacity', EngineCapacityController::class);
    Route::resource('/data-mobil/transmission', TransmissionController::class);
    Route::resource('/data-mobil/bahan-bakar', FuelTypeController::class);
    Route::resource('/data-mobil/periode', ProductionPeriodController::class);
    Route::resource('/data-mobil/cars', CarsController::class);
});
