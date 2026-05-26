<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hrd\DivisiController;
use App\Http\Controllers\Hrd\DashboardController as HrdDashboardController;
use App\Http\Controllers\Hrd\KaryawanController;
use App\Http\Controllers\Lead\DashboardController as LeadDashboardController;
use App\Http\Controllers\Head\DashboardController as HeadDashboardController;
use App\Http\Controllers\Direktur\DashboardController as DirekturDashboardController;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Hrd\JenisCutiController;
use App\Http\Controllers\Hrd\HakCutiController;

Route::get('/', function () {
    return view('welcome');
});

// Generic dashboard (will be redirected by auth)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ROLE-BASED DASHBOARDS
Route::middleware(['auth', 'role:hrd'])->group(function () {
    Route::get('/hrd/dashboard', [HrdDashboardController::class, 'index'])
        ->name('hrd.dashboard');
});

Route::middleware(['auth', 'role:lead'])->group(function () {
    Route::get('/lead/dashboard', [LeadDashboardController::class, 'index'])
        ->name('lead.dashboard');
});

Route::middleware(['auth', 'role:head'])->group(function () {
    Route::get('/head/dashboard', [HeadDashboardController::class, 'index'])
        ->name('head.dashboard');
});

Route::middleware(['auth', 'role:direktur'])->group(function () {
    Route::get('/direktur/dashboard', [DirekturDashboardController::class, 'index'])
        ->name('direktur.dashboard');
});

Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', [KaryawanDashboardController::class, 'index'])
        ->name('karyawan.dashboard');
});

// HRD MODULE ROUTES
Route::middleware(['auth', 'role:hrd'])->group(function () {
    Route::resource('/hrd/divisi', DivisiController::class);
    Route::resource('/hrd/karyawan', KaryawanController::class);
    Route::resource('/hrd/jenis_cuti', JenisCutiController::class);
    Route::resource('/hrd/hak_cuti', HakCutiController::class);
});



require __DIR__ . '/auth.php';
