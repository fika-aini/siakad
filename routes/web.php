<?php

use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\MahasiswaController; 
use App\Http\Controllers\PageController;
use App\Models\Mahasiswa;
use Illuminate\Http\Request; 

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
Route::resource('mahasiswa', MahasiswaController::class);
Route::get('cari',[MahasiswaController::class, 'cari'])->name('cari');
Route::get('mahasiswa/nilai/{nim}',[MahasiswaController::class,'nilai'])->name('mahasiswa.nilai');