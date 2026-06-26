<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TentorController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaKelasController;
use App\Http\Controllers\Admin\NaikKelasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\PeriodeJadwalController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\SesiController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\LaporanSiswaController;
use App\Http\Controllers\Admin\LaporanAbsensiController;
use App\Http\Controllers\Admin\LaporanQuizController;

use App\Http\Controllers\Siswa\JadwalController as SiswaJadwalController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\Siswa\QuizController as SiswaQuizController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

use App\Http\Controllers\Tentor\JadwalController as TentorJadwalController;
use App\Http\Controllers\Tentor\AbsensiController as TentorAbsensiController;
use App\Http\Controllers\Tentor\QuizController as TentorQuizController;
use App\Http\Controllers\Tentor\DashboardController as TentorDashboardController;
/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
->middleware(['auth', 'role:admin'])
->group(function () {

    // ✅ DASHBOARD
     Route::get('/', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
    
    // ======================
    // SISWA
    // ======================
    Route::get('/siswa', [SiswaController::class, 'index']);
    Route::get('/siswa/create', [SiswaController::class, 'create']);
    Route::post('/siswa', [SiswaController::class, 'store']);
    Route::get('/kelas/naik-kelas', [NaikKelasController::class, 'index']);
    Route::post('/kelas/naik-kelas', [NaikKelasController::class, 'proses']);
    
    Route::get('/siswa/{id}', [SiswaController::class, 'detail']);

    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit']);
    Route::put('/siswa/{id}', [SiswaController::class, 'update']);
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy']);
    
    // ======================
    // TENTOR
    // ======================
    Route::get('/tentor', [TentorController::class, 'index']);
    Route::get('/tentor/create', [TentorController::class, 'create']);
    Route::post('/tentor', [TentorController::class, 'store']);
    Route::get('/tentor/{id}/edit', [TentorController::class, 'edit']);
    Route::put('/tentor/{id}', [TentorController::class, 'update']);
    Route::delete('/tentor/{id}', [TentorController::class, 'destroy']);

    // ======================
    // PROGRAM
    // ======================
    Route::get('/program', [ProgramController::class, 'index']);
    Route::get('/program/create', [ProgramController::class, 'create']);
    Route::post('/program', [ProgramController::class, 'store']);
    Route::get('/program/{id}/edit', [ProgramController::class, 'edit']);
    Route::put('/program/{id}', [ProgramController::class, 'update']);
    Route::delete('/program/{id}', [ProgramController::class, 'destroy']);

    // ======================
    // KELAS
    // ======================
    Route::get('/kelas', [KelasController::class, 'index']);
    Route::get('/kelas/create', [KelasController::class, 'create']);
    Route::post('/kelas', [KelasController::class, 'store']);
    Route::get('/kelas/{id}/edit', [KelasController::class, 'edit']);
    Route::put('/kelas/{id}', [KelasController::class, 'update']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy']);
    Route::get( '/kelas/{kelas}/siswa',[NaikKelasController::class, 'getSiswa']);

    // TAMBAHan untuk laporan per kelas
    Route::get('/kelas/{id}/laporan', [KelasController::class, 'laporan']);
    
    // ======================
    // RUANGAN
    // ======================
    Route::resource('ruangan', RuanganController::class)
    ->names('admin.ruangan');

    // ======================
    // mapel
    // ======================
    Route::resource('mata_pelajaran', MataPelajaranController::class)
    ->names('admin.mata_pelajaran');

    
    // ======================
    // SESI 
    // ======================
    Route::resource('sesi', SesiController::class)
        ->names('admin.sesi');

    // ======================
    // JADWAL
    // ======================
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/create', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('/jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    Route::get('/jadwal/mingguan', [JadwalController::class, 'jadwalmingguanCreate'])
    ->name('jadwal.mingguan');
    Route::post('/jadwal/mingguan', [JadwalController::class, 'jadwalmingguanStore'])
    ->name('jadwal.mingguan.store');
    Route::get('/jadwal/matrix', [JadwalController::class, 'matrix'])
    ->name('jadwal.matrix');
    
    // periode//
    Route::get('/periode', [PeriodeJadwalController::class, 'index'])->name('periode.index');
    Route::get('/periode/create', [PeriodeJadwalController::class, 'create'])->name('periode.create');
    Route::post('/periode', [PeriodeJadwalController::class, 'store'])->name('periode.store');

    Route::get('/periode/aktifkan/{id}', [PeriodeJadwalController::class, 'aktifkan'])->name('periode.aktifkan');
    Route::post('/periode/{id}/copy-jadwal',[PeriodeJadwalController::class, 'copyJadwal'])->name('periode.copy');
    Route::delete('/periode/{id}', [PeriodeJadwalController::class, 'destroy'])->name('periode.destroy');

    //ABSENSI//
    Route::get('/absensi',[AbsensiController::class, 'index'] )->name('absensi.index');

    Route::get('/absensi/{absensi}/edit',[AbsensiController::class, 'edit']
        )->name('absensi.edit');

    Route::put('/absensi/{absensi}',[AbsensiController::class, 'update']
        )->name('absensi.update');
    
    Route::delete('/absensi/{jadwal}',[AbsensiController::class, 'destroy']
        )->name('absensi.destroy');

    Route::get('/absensi/kelas/{jadwal}',[AbsensiController::class, 'show']
        )->name('absensi.detail');


    //nilai kuis//
    Route::get('/quiz',[QuizController::class, 'index']
        )->name('quiz.index');
    
    Route::get('/quiz/{quiz}/detail',[QuizController::class, 'detail']
        )->name('quiz.detail');

    Route::get('/quiz/nilai/{nilai}/edit', [QuizController::class, 'editNilai'])
         ->name('quiz.edit');

    Route::put('/quiz/nilai/{nilai}', [QuizController::class, 'updateNilai'])
        ->name('quiz.update');
    /*
    |--------------------------------------------------------------------------
    | LAPORAN SISWA
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan-siswa',[LaporanSiswaController::class, 'index']
    )->name('laporan.siswa.index');

    Route::get('/laporan-siswa/{siswa}',[LaporanSiswaController::class, 'detail']
    )->name('laporan.siswa.detail');

    Route::get('/laporan-siswa/{siswa}/pdf', [LaporanSiswaController::class, 'pdf']
    )->name('laporan.siswa.pdf');

    //laporan absensi//
    Route::get('/laporan/absensi',[LaporanAbsensiController::class, 'index']
    )->name('laporan.absensi');

    Route::get('/laporan/absensi/pdf',[LaporanAbsensiController::class, 'exportPdf']
    )->name('laporan.absensi.pdf');

    Route::get('/laporan/quiz',[LaporanQuizController::class, 'index']
    )->name('laporan.quiz.index');

    Route::get('admin/laporan/quiz/pdf',[LaporanQuizController::class, 'exportPdf']
    )->name('laporan.quiz.pdf');

    // ======================
    // USERS
    // ======================
    Route::resource('users', UserController::class);

    Route::get('/users/{id}/reset-password',
        [UserController::class, 'resetPassword'])
        ->name('admin.users.reset-password');
});

/*
|--------------------------------------------------------------------------
| SISWA AREA
|--------------------------------------------------------------------------
*/
Route::prefix('siswa')
    ->middleware(['auth', 'role:siswa'])
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('siswa.dashboard');
        });

        Route::get(
            '/dashboard',
            [SiswaDashboardController::class, 'index']
        )->name('siswa.dashboard');

        Route::get('/profil', function () {

            $siswa = auth()->user()->siswa;

            return view('siswa.profil', compact('siswa'));

        });

        // JADWAL SISWA
        Route::get(
            '/jadwal',
            [SiswaJadwalController::class, 'index']
        )->name('siswa.jadwal');

        // ABSENSI
        Route::get(
            '/absensi',
            [SiswaAbsensiController::class, 'index']
        )->name('siswa.absensi');

        // QUIZ
        Route::get(
            '/quiz',
            [SiswaQuizController::class, 'index']
        )->name('siswa.quiz');

});
/*
|--------------------------------------------------------------------------
| TENTOR AREA
|--------------------------------------------------------------------------
*/
    Route::prefix('tentor')
    ->middleware(['auth', 'role:tentor'])
    ->group(function () {

        Route::get('/', function () {
            return redirect()->route('tentor.dashboard');
        });

        Route::get(
            '/dashboard',
            [TentorDashboardController::class, 'index']
        )->name('tentor.dashboard');


        // JADWAL TENTOR
        Route::get(
            '/jadwal',
            [TentorJadwalController::class, 'index']
        )->name('tentor.jadwal');

        // FORM ABSENSI
        Route::get(
            '/absensi/{jadwal}',
            [TentorAbsensiController::class, 'create']
        )->name('tentor.absensi.create');

        // SIMPAN ABSENSI
        Route::post(
            '/absensi/{jadwal}',
            [TentorAbsensiController::class, 'store']
        )->name('tentor.absensi.store');

        // QUIZ
        Route::get(
            '/quiz/{jadwal}',
            [TentorQuizController::class, 'create']
        )->name('tentor.quiz.create');

        Route::post(
        '/quiz/{jadwal}',
        [TentorQuizController::class, 'store']
    )->name('tentor.quiz.store');
});