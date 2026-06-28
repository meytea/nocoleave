<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\PengajuanCutiController as KaryawanPengajuanCutiController;
use App\Http\Controllers\Karyawan\RiwayatApprovalController as KaryawanRiwayatApprovalController;
use App\Http\Controllers\Lead\DashboardController as LeadDashboardController;
use App\Http\Controllers\Lead\KaryawanController as LeadKaryawanController;
use App\Http\Controllers\Lead\PengajuanCutiController as LeadPengajuanCutiController;
use App\Http\Controllers\Lead\ApprovalCutiController as LeadApprovalCutiController;
use App\Http\Controllers\Head\DashboardController as HeadDashboardController;
use App\Http\Controllers\Head\ApprovalCutiController as HeadApprovalCutiController;
use App\Http\Controllers\Head\PengajuanCutiController as HeadPengajuanCutiController;
use App\Http\Controllers\Head\KaryawanController as HeadKaryawanController;
use App\Http\Controllers\Direktur\DashboardController as DirekturDashboardController;
use App\Http\Controllers\Direktur\ApprovalCutiController as DirekturApprovalCutiController;
use App\Http\Controllers\Hrd\DivisiController;
use App\Http\Controllers\Hrd\DashboardController as HrdDashboardController;
use App\Http\Controllers\Hrd\KaryawanController;
use App\Http\Controllers\Hrd\JenisCutiController;
use App\Http\Controllers\Hrd\HakCutiController;
use App\Http\Controllers\Hrd\PengajuanCutiController as HRDPengajuanCutiController;
use App\Http\Controllers\Hrd\RiwayatCutiController;
use App\Http\Controllers\Hrd\ApprovalCutiController as HrdApprovalCutiController;
use App\Http\Controllers\Hrd\RiwayatApprovalController as HrdRiwayatApprovalController;
use App\Http\Controllers\Hrd\HeadController;


Route::get('/', function () {
    return redirect()->route('login');
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

// ROLE-BASED LEAD
Route::middleware(['auth', 'role:lead'])->group(function () {
    Route::get('/lead/dashboard', [LeadDashboardController::class, 'index'])->name('lead.dashboard');
    Route::resource('/lead/karyawan', LeadKaryawanController::class)->names('lead.karyawan');
    Route::get('/lead/pengajuan_cuti/disetujui', [LeadPengajuanCutiController::class, 'pengajuanDisetujui'])->name('lead.pengajuan_cuti.disetujui');
    Route::get('/lead/pengajuan_cuti/ditolak', [LeadPengajuanCutiController::class, 'pengajuanDitolak'])->name('lead.pengajuan_cuti.ditolak');
    Route::resource('/lead/pengajuan_cuti', LeadPengajuanCutiController::class)->names('lead.pengajuan_cuti');
    Route::resource('/lead/approval_cuti', LeadApprovalCutiController::class)->names('lead.approval_cuti');
    
    Route::get('/lead/approval_cuti/pengajuan/ditolak', [LeadApprovalCutiController::class, 'pengajuanDitolak'])->name('lead.approval_cuti.ditolak');
    Route::get('/lead/approval_cuti/pengajuan/disetujui', [LeadApprovalCutiController::class, 'pengajuanDisetujui'])->name('lead.approval_cuti.disetujui');
    Route::post('/lead/approval_cuti/{pengajuanCuti}/setuju', [LeadApprovalCutiController::class, 'setuju'])->name('lead.approval_cuti.setuju');
    Route::post('/lead/approval_cuti/{pengajuanCuti}/tolak', [LeadApprovalCutiController::class, 'tolak'])->name('lead.approval_cuti.tolak');
    //Route::get('/lead/pengajuan_cuti/{pengajuanCuti}', [LeadPengajuanCutiController::class, 'show'])->name('lead.pengajuan_cuti.show');
});

// ROLE-BASED HEAD
Route::middleware(['auth', 'role:head'])->group(function () {
    Route::get('/head/dashboard', [HeadDashboardController::class, 'index'])->name('head.dashboard');
    Route::resource('/head/karyawan', HeadKaryawanController::class)->names('head.karyawan');
    Route::resource('head/pengajuan_cuti', HeadPengajuanCutiController::class)->names('head.pengajuan_cuti');
    Route::resource('/head/approval_cuti', HeadApprovalCutiController::class)->names('head.approval_cuti');
    Route::get('/head/pengajuan-cuti/disetujui', [HeadPengajuanCutiController::class, 'pengajuanDisetujui'])->name('head.pengajuan_cuti.disetujui');
    Route::get('/head/pengajuan-cuti/ditolak', [HeadPengajuanCutiController::class, 'pengajuanDitolak'])->name('head.pengajuan_cuti.ditolak');
    Route::get('/head/approval_cuti/pengajuan/ditolak', [HeadApprovalCutiController::class, 'pengajuanDitolak'])->name('head.approval_cuti.ditolak');
    Route::get('/head/approval_cuti/pengajuan/disetujui', [HeadApprovalCutiController::class, 'pengajuanDisetujui'])->name('head.approval_cuti.disetujui');
    Route::post('/head/approval_cuti/{pengajuanCuti}/setuju', [HeadApprovalCutiController::class, 'setuju'])->name('head.approval_cuti.setuju');
    Route::post('/head/approval_cuti/{pengajuanCuti}/tolak', [HeadApprovalCutiController::class, 'tolak'])->name('head.approval_cuti.tolak');
});

// ROLE-BASED DIREKTUR
Route::middleware(['auth', 'role:direktur'])->group(function () {
    Route::get('/direktur/dashboard', [DirekturDashboardController::class, 'index'])
        ->name('direktur.dashboard');
    
    Route::resource('/direktur/approval_cuti', DirekturApprovalCutiController::class)->names('direktur.approval_cuti');
    Route::get('/direktur/approval_cuti/pengajuan/ditolak', [DirekturApprovalCutiController::class, 'pengajuanDitolak'])->name('direktur.approval_cuti.ditolak');
    Route::get('/direktur/approval_cuti/pengajuan/disetujui', [DirekturApprovalCutiController::class, 'pengajuanDisetujui'])->name('direktur.approval_cuti.disetujui');
    Route::post('/direktur/approval_cuti/{pengajuanCuti}/setuju', [DirekturApprovalCutiController::class, 'setuju'])->name('direktur.approval_cuti.setuju');
    Route::post('/direktur/approval_cuti/{pengajuanCuti}/tolak', [DirekturApprovalCutiController::class, 'tolak'])->name('direktur.approval_cuti.tolak');
});

// ROLE-BASED KARYAWAN
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/karyawan/dashboard', [KaryawanDashboardController::class, 'index'])->name('karyawan.dashboard');
    // Route::resource('/karyawan/pengajuan_cuti', KaryawanPengajuanCutiController::class)->only(['index', 'create', 'store'])->names('karyawan.pengajuan_cuti');
    Route::get('/karyawan/pengajuan_cuti/disetujui', [KaryawanPengajuanCutiController::class, 'pengajuanDisetujui'])->name('karyawan.pengajuan_cuti.disetujui');
    Route::get('/karyawan/pengajuan_cuti/ditolak', [KaryawanPengajuanCutiController::class, 'pengajuanDitolak'])->name('karyawan.pengajuan_cuti.ditolak');
    Route::resource('/karyawan/pengajuan_cuti', KaryawanPengajuanCutiController::class)->names('karyawan.pengajuan_cuti');
    Route::get(
    '/karyawan/hak-cuti',
    [KaryawanPengajuanCutiController::class, 'getHakCuti']
)->name('karyawan.hak_cuti');
    
    //Route::get('/karyawan/pengajuan_cuti/{pengajuanCuti}', [KaryawanPengajuanCutiController::class, 'show'])->name('karyawan.pengajuan_cuti.show');
});

// ROLE-BASED HRD
Route::middleware(['auth', 'role:hrd'])->group(function () {
    Route::resource('/hrd/divisi', DivisiController::class);
    Route::resource('/hrd/karyawan', KaryawanController::class);
    Route::resource('/hrd/jenis_cuti', JenisCutiController::class);
    // Route::post('/hak-cuti/generate', [HakCutiController::class, 'generateTahunBaru'])->name('hak_cuti.generate');
        Route::get('/hrd/riwayat_cuti/disetujui', [RiwayatCutiController::class, 'disetujui'])->name('hrd.riwayat_cuti.disetujui');
    Route::get(
    '/hrd/laporan_cuti',
    [RiwayatCutiController::class, 'laporan']
)->name('hrd.riwayat_cuti.laporan');
Route::post(
    '/hrd/laporan_cuti/export',
    [RiwayatCutiController::class, 'export']
)->name('hrd.riwayat_cuti.export');
    Route::resource('/hrd/hak_cuti', HakCutiController::class);
    Route::post(
    '/hrd/hak_cuti/generate',
    [HakCutiController::class, 'generate']
)->name('hak_cuti.generate');

    Route::resource('/hrd/riwayat_cuti', RiwayatCutiController::class);
    Route::resource('/hrd/pengajuan_cuti', HrdPengajuanCutiController::class)->names('hrd.pengajuan_cuti');
    Route::resource('/hrd/approval_cuti', HrdApprovalCutiController::class)->names('hrd.approval_cuti');
    Route::get('/hrd/approval_cuti/pengajuan/ditolak', [HrdApprovalCutiController::class, 'pengajuanDitolak'])->name('hrd.approval_cuti.ditolak');
    Route::get('/hrd/approval_cuti/pengajuan/disetujui', [HrdApprovalCutiController::class, 'pengajuanDisetujui'])->name('hrd.approval_cuti.disetujui');
    Route::post('/hrd/approval_cuti/{pengajuanCuti}/setuju', [HrdApprovalCutiController::class, 'setuju'])->name('hrd.approval_cuti.setuju');
    Route::post('/hrd/approval_cuti/{pengajuanCuti}/tolak', [HrdApprovalCutiController::class, 'tolak'])->name('hrd.approval_cuti.tolak');
    Route::get('/hrd/riwayat_approval', [HrdRiwayatApprovalController::class, 'index'])->name('hrd.riwayat_approval.index');
    Route::resource('/hrd/head', HeadController::class)->names('head');
    Route::get('/hrd/pengajuan-cuti/disetujui', [HrdPengajuanCutiController::class, 'pengajuanDisetujui'])->name('hrd.pengajuan_cuti.disetujui');
    Route::get('/hrd/pengajuan-cuti/ditolak', [HrdPengajuanCutiController::class, 'pengajuanDitolak'])->name('hrd.pengajuan_cuti.ditolak');
    Route::get('/hrd/pengajuan_cuti/{pengajuanCuti}', [HrdPengajuanCutiController::class, 'show'])->name('hrd.pengajuan_cuti.show');
    // Route::get('/hrd/riwayat_cuti/{pengajuanCuti}', [RiwayatCutiController::class, 'show'])->name('hrd.riwayat_cuti.show');
});



require __DIR__ . '/auth.php';
