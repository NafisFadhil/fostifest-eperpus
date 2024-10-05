<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/data', [App\Http\Controllers\HomeController::class, 'data'])->name('home.data');
Route::get('/home/data/admin', [App\Http\Controllers\HomeController::class, 'dataAdmin'])->name('home.data.admin');
Route::middleware(['auth'])->group(function () {

	// Master Data Kelas
	Route::get('kelas/data', [App\Http\Controllers\KelasController::class, 'data'])->name('kelas.data');
	Route::resource('kelas', App\Http\Controllers\KelasController::class)->parameters(['kelas' => 'kelas']);

	// Master Absensi Izin
	Route::get('master-izin/data', [App\Http\Controllers\MasterIzinControler::class, 'data'])->name('master-izin.data');
	Route::resource('master-izin', App\Http\Controllers\MasterIzinControler::class)->parameters(['master-izin' => 'master-izin']);

	// Master User
	Route::get('user/data', [App\Http\Controllers\UserController::class, 'data'])->name('user.data');
	Route::post('user/import', [App\Http\Controllers\UserController::class, 'import'])->name('user.import');
	Route::resource('user', App\Http\Controllers\UserController::class)->parameters(['user' => 'user']);

	// Setting
	Route::get('setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
	Route::post('setting', [App\Http\Controllers\SettingController::class, 'store'])->name('setting.store');

	// Izin
	Route::get('izin', [App\Http\Controllers\IzinController::class, 'index'])->name('izin.index');
	Route::post('izin', [App\Http\Controllers\IzinController::class, 'store'])->name('izin.store');

    //Absen
    Route::get('absen', [App\Http\Controllers\AttendanceController::class, 'index'])->name('absen.index');
    Route::post('absen', [App\Http\Controllers\AttendanceController::class, 'store'])->name('absen.store');

    //Laporan Harian
    Route::get('laporan-harian', [App\Http\Controllers\LaporanHarianController::class, 'index'])->name('laporan_harian.index');
    Route::get('laporan-harian/data', [App\Http\Controllers\LaporanHarianController::class, 'data'])->name('laporan_harian.data');

    //Laporan Bulanan
    Route::get('laporan-bulanan', [App\Http\Controllers\LaporanBulananController::class, 'index'])->name('laporan_bulanan.index');
    Route::get('laporan-bulanan/data', [App\Http\Controllers\LaporanBulananController::class, 'data'])->name('laporan_bulanan.data');


    //Buku
    Route::get('buku', [App\Http\Controllers\MasterBukuController::class, 'index'])->name('master-buku.index');
    Route::get('buku/show/{id}', [App\Http\Controllers\MasterBukuController::class, 'show'])->name('master-buku.show');
    Route::get('buku/data', [App\Http\Controllers\MasterBukuController::class, 'data'])->name('master-buku.data');
    Route::get('buku/create', [App\Http\Controllers\MasterBukuController::class, 'create'])->name('master-buku.create');
    Route::get('buku/edit/{id}', [App\Http\Controllers\MasterBukuController::class, 'edit'])->name('master-buku.edit');
    Route::post('buku/store', [App\Http\Controllers\MasterBukuController::class, 'store'])->name('master-buku.store');
    Route::post('buku/update', [App\Http\Controllers\MasterBukuController::class, 'update'])->name('master-buku.update');
    Route::delete('buku/delete/{id}', [App\Http\Controllers\MasterBukuController::class, 'destroy'])->name('master-buku.delete');
});
