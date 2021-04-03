<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideosController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/dashboard', [VideosController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/upload', [VideosController::class, 'upload'])->middleware(['auth'])->name('upload');
Route::post('/store', [VideosController::class, 'store'])->middleware(['auth'])->name('store');

require __DIR__.'/auth.php';
