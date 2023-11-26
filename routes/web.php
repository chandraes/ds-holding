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
        Route::view('db', 'db.index')->name('db');
        Route::prefix('db')->group(function () {
            Route::get('/divisi', [App\Http\Controllers\DivisiController::class, 'index'])->name('db.divisi');
            Route::post('/divisi/store', [App\Http\Controllers\DivisiController::class, 'store'])->name('db.divisi.store');
            Route::patch('/divisi/{divisi}/update', [App\Http\Controllers\DivisiController::class, 'update'])->name('db.divisi.update');
            Route::delete('/divisi/destroy/{divisi}', [App\Http\Controllers\DivisiController::class, 'destroy'])->name('db.divisi.delete');

            Route::get('/rekening', [App\Http\Controllers\RekeningController::class, 'index'])->name('db.rekening');
            Route::patch('/rekening/{rekening}/update', [App\Http\Controllers\RekeningController::class, 'update'])->name('db.rekening.update');
        });
    });
});


