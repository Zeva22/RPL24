<?php

use App\Http\Controllers\AuthController as AuthControllerAlias;
use App\Http\Controllers\DashboardController as DashboardControllerAlias;
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
    return view('welcome');
});

Route::get('/login',[AuthControllerAlias::class, 'index'])->name('auth.index')->middleware('guest');
Route::post('/login',[AuthControllerAlias::class, 'verify'])->name('auth.verify');

Route::group(['middleware' => 'auth:user'], function (){
    Route::prefix('admin')->group(function (){
        Route::get('/',[DashboardControllerAlias::class, 'index'])->name('dashboard.index');
        Route::get('/profile',[DashboardControllerAlias::class, 'profile'])->name('dashboard.profile');
        Route::get('/reset-password',[DashboardControllerAlias::class, 'resetPassword'])->name('dashboard.resetPassword');
        Route::post('/reset-password',[DashboardControllerAlias::class, 'prosesResetPassword'])->name('dashboard.prosesResetPassword');

        Route::get('/kategori', [\App\Http\Controllers\KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/tambah', [\App\Http\Controllers\KategoriController::class, 'tambah'])->name('kategori.tambah');
        Route::post('/kategori/prosesTambah', [\App\Http\Controllers\KategoriController::class, 'prosesTambah'])->name('kategori.prosesTambah');
        Route::get('/kategori/ubah/{id}', [\App\Http\Controllers\KategoriController::class, 'ubah'])->name('kategori.ubah');
        Route::post('/kategori/prosesUbah', [\App\Http\Controllers\KategoriController::class, 'prosesUbah'])->name('kategori.prosesUbah');
        Route::get('/kategori/hapus/{id}', [\App\Http\Controllers\KategoriController::class, 'hapus'])->name('kategori.hapus');
        Route::get('/kategori/export-pdf', [\App\Http\Controllers\KategoriController::class, 'exportPdf'])->name('kategori.exportPdf');

        Route::get('/berita', [\App\Http\Controllers\BeritaController::class, 'index'])->name('berita.index');
        Route::get('/berita/tambah', [\App\Http\Controllers\BeritaController::class, 'tambah'])->name('berita.tambah');
        Route::post('/berita/prosesTambah', [\App\Http\Controllers\BeritaController::class, 'prosesTambah'])->name('berita.prosesTambah');
        Route::get('/berita/ubah/{id}', [\App\Http\Controllers\BeritaController::class, 'ubah'])->name('berita.ubah');
        Route::post('/berita/prosesUbah', [\App\Http\Controllers\BeritaController::class, 'prosesUbah'])->name('berita.prosesUbah');
        Route::get('/berita/hapus{id}', [\App\Http\Controllers\BeritaController::class, 'hapus'])->name('berita.hapus');

        Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::get('/user/tambah', [\App\Http\Controllers\UserController::class, 'tambah'])->name('user.tambah');
        Route::post('/user/prosesTambah', [\App\Http\Controllers\UserController::class, 'prosesTambah'])->name('user.prosesTambah');
        Route::get('/user/ubah/{id}', [\App\Http\Controllers\UserController::class, 'ubah'])->name('user.ubah');
        Route::post('/user/prosesUbah', [\App\Http\Controllers\UserController::class, 'prosesUbah'])->name('user.prosesUbah');
        Route::get('/user/hapus/{id}', [\App\Http\Controllers\UserController::class, 'hapus'])->name('user.hapus');

    });

    Route::get('/logout',[AuthControllerAlias::class, 'logout'])->name('auth.logout');
});

Route::get('files/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name('storage');