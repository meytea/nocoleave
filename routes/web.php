<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ROLE HRD
Route::middleware(['auth', 'role:hrd'])->group(function () {

    Route::get('/hrd/dashboard', [DashboardController::class, 'index'])
        ->name('hrd.dashboard');

    Route::resource('/hrd/divisi', DivisiController::class);
    Route::resource('/hrd/karyawan', KaryawanController::class);

});

//ROLE KARYAWAN


//HRD
// Route::middleware(['role:hrd'])->group(function () {

//         Route::get('/hrd/dashboard', function () {
//             return view('dashboard.hrd');
//         })->name('hrd.dashboard');
// });



require __DIR__.'/auth.php';
