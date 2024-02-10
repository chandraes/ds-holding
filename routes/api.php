<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\DividenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/get-token', [LoginController::class, 'login'])->name('get-token');

Route::middleware('auth:api')->group( function () {
    Route::get('/dividen', [DividenController::class, 'index'])->name('dividen');
    Route::post('/divisi', [DividenController::class, 'divisi'])->name('divisi');
});
