<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MahasiswaController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('mahasiswas', MahasiswaController::class);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [MahasiswaController::class, 'search'])->name('search');
Route::get('/khs/{Nim}', [MahasiswaController::class, 'khs'])->name('khs');
// Route::get('/article/cetak_pdf', [ArticleController::class, 'cetak_pdf']);
Route::get('/khs/{mahasiswa_id}/print_pdf', [MahasiswaController::class, 'print_pdf'])->name('print_pdf');