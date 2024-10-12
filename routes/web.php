<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__ . '/auth.php';




// Route::get('/', function () {
//     return redirect('/login');
// });

 Auth::routes(['register' => false]);

Route::middleware('guest')->group(function () {
    Route::get('/masuk', [\App\Http\Controllers\MasukController::class, 'login'])->name('masuk');
    Route::post('/masuk', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('masuk.post');
    Route::get('/daftar', [\App\Http\Controllers\MasukController::class, 'daftar'])->name('daftar');
    Route::post('/daftar', [\App\Http\Controllers\MasukController::class, 'registrasi'])->name('daftar.post');
});

Route::controller(LandingPageController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/detail/{id}', 'book');
    Route::get('/checkout/{id}', 'checkout');
    Route::get('/mybook', 'mybook');
    Route::get('profil', 'profil')->name('profil');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/data', [App\Http\Controllers\HomeController::class, 'data'])->name('home.data');
Route::get('/home/data/admin', [App\Http\Controllers\HomeController::class, 'dataAdmin'])->name('home.data.admin');
Route::middleware(['auth'])->group(function () {

    // Master Data Season
    Route::get('season/data', [App\Http\Controllers\SeasonController::class, 'data'])->name('season.data');
    Route::resource('season', App\Http\Controllers\SeasonController::class)->parameters(['season' => 'season']);

    // Master User
    Route::get('user/data', [App\Http\Controllers\UserController::class, 'data'])->name('user.data');
    Route::post('user/import', [App\Http\Controllers\UserController::class, 'import'])->name('user.import');
    Route::resource('user', App\Http\Controllers\UserController::class)->parameters(['user' => 'user']);
    
    //Laporan Harian
    Route::get('laporan-harian', [App\Http\Controllers\LaporanHarianController::class, 'index'])->name('laporan_harian.index');
    Route::get('laporan-harian/data', [App\Http\Controllers\LaporanHarianController::class, 'data'])->name('laporan_harian.data');

    //Buku
    Route::get('buku/data', [App\Http\Controllers\MasterBukuController::class, 'data'])->name('master-buku.data');
    Route::resource('buku', App\Http\Controllers\MasterBukuController::class)->names([
        'index' => 'master-buku.index',
        'create' => 'master-buku.create',
        'edit' => 'master-buku.edit',
        'store' => 'master-buku.store',
        'update' => 'master-buku.update',
        'destroy' => 'master-buku.delete',
    ])->except('show');

    //Level
    Route::get('level/data', [App\Http\Controllers\MasterLevelController::class, 'data'])->name('master-level.data');
    Route::resource('level', App\Http\Controllers\MasterLevelController::class)->names([
        'index' => 'master-level.index',
        'create' => 'master-level.create',
        'edit' => 'master-level.edit',
        'store' => 'master-level.store',
        'update' => 'master-level.update',
        'destroy' => 'master-level.delete',
    ])->except('show');

    //Peminjaman
    Route::get('master-peminjaman/data', [App\Http\Controllers\PeminjamanController::class, 'data'])->name('peminjaman.data');
    Route::get('master-peminjaman/poin/{id}', [App\Http\Controllers\PeminjamanController::class, 'poin'])->name('peminjaman.poin');
    Route::put('master-peminjaman/poin/{id}/update', [App\Http\Controllers\PeminjamanController::class, 'poinUpdate'])->name('peminjaman.poin.update');
    Route::post('peminjaman/return/{id}', [App\Http\Controllers\PeminjamanController::class, 'return'])->name('peminjaman.return');
    Route::post('peminjaman/borrow/{id}', [App\Http\Controllers\PeminjamanController::class, 'borrow'])->name('peminjaman.borrow');

    Route::resource('master-peminjaman', App\Http\Controllers\PeminjamanController::class)->names([
        'index' => 'peminjaman.index',
        'create' => 'peminjaman.create',
        'edit' => 'peminjaman.edit',
        'store' => 'peminjaman.store',
        'update' => 'peminjaman.update',
        'destroy' => 'peminjaman.delete',
    ])->except('show', 'return', 'borrow', 'poin', 'poinUpdate');

    Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
Route::get('/token', function () {
    return csrf_token();
});
