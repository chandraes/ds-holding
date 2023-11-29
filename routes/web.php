<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes([
    'register' => false,
]);

Route::group(['middleware' => ['auth']], function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => ['role:admin']], function() {
        Route::view('pengaturan', 'pengaturan.index')->name('pengaturan');
        Route::prefix('pengaturan')->group(function () {
            Route::get('/wa', [App\Http\Controllers\WaController::class, 'index'])->name('pengaturan.wa');
            Route::get('/wa/get-wa-group', [App\Http\Controllers\WaController::class, 'get_group_wa'])->name('pengaturan.wa.get-group-wa');
            Route::patch('/wa/{group_wa}/update', [App\Http\Controllers\WaController::class, 'update'])->name('pengaturan.wa.update');

            Route::get('/akun', [App\Http\Controllers\PengaturanController::class, 'index'])->name('pengaturan.akun');
            Route::post('/akun/store', [App\Http\Controllers\PengaturanController::class, 'store'])->name('pengaturan.akun.store');
            Route::patch('/akun/{akun}/update', [App\Http\Controllers\PengaturanController::class, 'update'])->name('pengaturan.akun.update');
            Route::delete('/akun/{akun}/delete', [App\Http\Controllers\PengaturanController::class, 'destroy'])->name('pengaturan.akun.delete');
        });

        Route::view('db', 'db.index')->name('db');
        Route::prefix('db')->group(function () {

            Route::get('/persen-kas', [App\Http\Controllers\PersenKasController::class, 'index'])->name('persen-kas');
            Route::patch('/persen-kas/{persenKas}/update', [App\Http\Controllers\PersenKasController::class, 'update'])->name('persen-kas.update');

            Route::get('/komisaris', [App\Http\Controllers\KomisarisController::class, 'index'])->name('komisaris');
            Route::post('/komisaris/store', [App\Http\Controllers\KomisarisController::class, 'store'])->name('komisaris.store');
            Route::patch('/komisaris/{komisaris}/update', [App\Http\Controllers\KomisarisController::class, 'update'])->name('komisaris.update');
            Route::delete('/komisaris/destroy/{komisaris}', [App\Http\Controllers\KomisarisController::class, 'destroy'])->name('komisaris.delete');

            Route::get('/persen-divisi', [App\Http\Controllers\PersenDivisiController::class, 'index'])->name('persen-divisi');
            Route::post('/persen-divisi/store', [App\Http\Controllers\PersenDivisiController::class, 'store'])->name('persen-divisi.store');
            Route::patch('/persen-divisi/{persenDivisi}/update', [App\Http\Controllers\PersenDivisiController::class, 'update'])->name('persen-divisi.update');
            Route::delete('/persen-divisi/destroy/{persenDivisi}', [App\Http\Controllers\PersenDivisiController::class, 'destroy'])->name('persen-divisi.delete');


            Route::get('/divisi', [App\Http\Controllers\DivisiController::class, 'index'])->name('db.divisi');
            Route::post('/divisi/store', [App\Http\Controllers\DivisiController::class, 'store'])->name('db.divisi.store');
            Route::patch('/divisi/{divisi}/update', [App\Http\Controllers\DivisiController::class, 'update'])->name('db.divisi.update');
            Route::delete('/divisi/destroy/{divisi}', [App\Http\Controllers\DivisiController::class, 'destroy'])->name('db.divisi.delete');

            Route::get('/rekening', [App\Http\Controllers\RekeningController::class, 'index'])->name('db.rekening');
            Route::patch('/rekening/{rekening}/update', [App\Http\Controllers\RekeningController::class, 'update'])->name('db.rekening.update');
        });


        Route::get('/isi-saldo', [App\Http\Controllers\BillingController::class, 'saldo_temp'])->name('isi-saldo');
    });

    Route::get('/billing', [App\Http\Controllers\BillingController::class, 'index'])->name('billing');
    Route::prefix('billing')->group(function () {
        Route::get('/kas-kecil/masuk', [App\Http\Controllers\FormKasKecilController::class, 'masuk'])->name('billing.kas-kecil.masuk');
        Route::post('/kas-kecil/masuk/store', [App\Http\Controllers\FormKasKecilController::class, 'masuk_store'])->name('kas-kecil.masuk.store');

        Route::get('/kas-kecil/keluar', [App\Http\Controllers\FormKasKecilController::class, 'keluar'])->name('billing.kas-kecil.keluar');
        Route::post('/kas-kecil/keluar/store', [App\Http\Controllers\FormKasKecilController::class, 'keluar_store'])->name('kas-kecil.keluar.store');
        Route::post('/kas-kecil/void/{id}', [App\Http\Controllers\FormKasKecilController::class, 'void'])->name('billing.kas-kecil.void');
    });

    Route::get('/rekap', [App\Http\Controllers\RekapController::class, 'index'])->name('rekap');
    Route::prefix('rekap')->group(function () {
        Route::get('/kas-kecil', [App\Http\Controllers\RekapController::class, 'kas_kecil'])->name('rekap.kas-kecil');
        Route::get('/kas-kecil/print/{bulan}/{tahun}', [App\Http\Controllers\RekapController::class, 'kas_kecil_print'])->name('rekap.kas-kecil.print');

        Route::get('/kas-besar', [App\Http\Controllers\RekapController::class, 'kas_besar'])->name('rekap.kas-besar');
        Route::get('/kas-besar/print/{bulan}/{tahun}', [App\Http\Controllers\RekapController::class, 'kas_besar_print'])->name('rekap.kas-besar.print');
    });
});


