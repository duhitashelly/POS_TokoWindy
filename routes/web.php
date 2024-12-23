<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk Barang
Route::prefix('barang')->controller(BarangController::class)->group(function () {
    Route::get('tampil-barang', 'index')->name('barang.tampil-barang');
    Route::get('tambah-barang', 'create')->name('barang.create');
    Route::post('tampil-barang', 'store')->name('barang.store');
    Route::get('edit/{id}', 'edit')->name('barang.edit');
    Route::post('edit/{id}', 'update')->name('barang.update');
    Route::post('delete/{id}', 'destroy')->name('barang.delete');
    Route::delete('{id}', 'destroy')->name('barang.destroy');
    Route::get('{id}/stok', 'editStok')->name('barang.editStok');
    Route::get('generate-kode', 'generateKodeBarang');
    Route::get('search/{query}', 'searchBarang');
    Route::post('simpan-transaksi', 'simpanTransaksi');
});

Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

// Route untuk Kategori
Route::prefix('kategori')->controller(KategoriController::class)->group(function () {
    Route::get('/', 'index')->name('kategori.index');
    Route::get('tambah-kategori', 'create')->name('kategori.create');
    Route::post('tampil-kategori', 'store')->name('kategori.store');
    Route::get('edit/{id}', 'edit')->name('kategori.edit');
    Route::post('edit/{id}', 'update')->name('kategori.update');
    Route::post('delete/{id}', 'destroy')->name('kategori.delete');
});

// Route untuk Transaksi
Route::prefix('transaksi')->controller(TransaksiController::class)->group(function () {
    Route::get('/', 'index')->name('transaksi.index');
    Route::get('create', 'create')->name('transaksi.create');
    Route::get('tambah/{id}', 'tambahPesanan')->name('transaksi.tambahPesanan');
    Route::put('update/{id}', 'updateQty')->name('transaksi.updateQty');
    Route::delete('hapus/{id}', 'destroy')->name('transaksi.destroy');
    Route::get('struk/{id}', 'showStruk')->name('transaksi.struk');
    Route::post('simpan', 'simpanTransaksi')->name('transaksi.simpanTransaksi');
    Route::get('cari', 'cariBarang')->name('transaksi.cariBarang');
    Route::get('filterBarang', 'filterBarang')->name('transaksi.filterBarang');
});

Route::get('/transaksi/chart-data', [TransaksiController::class, 'chartData'])->name('transaksi.chartData');
Route::get('/transaksi/areachart', [TransaksiController::class, 'getAreachart'])->name('transaksi.getAreachart');
Route::get('/dashboard', [TransaksiController::class, 'getDashboardData'])->name('dashboard');

// Middleware Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::view('/profile', 'profile.show')->name('profile.show');
    Route::view('/profile/index', 'profile.index')->name('profile.index');
    Route::delete('/user', function () {
        $user = Auth::user();
        $user->delete();
        Auth::logout();
        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    })->name('current-user.destroy');
});

// Route dengan CheckRole Middleware
Route::middleware(CheckRole::class)->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/tampil-barang', [BarangController::class, 'index'])->name('barang.tampil-barang');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::get('/kategori/tampil-kategori', [KategoriController::class, 'index'])->name('kategori.tampil-kategori');
    Route::get('/laporan/transaksi', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel']);
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/transaksi/pdf', [LaporanController::class, 'exportToPDF'])->name('laporan.exportPDF');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::get('/kategori/tambah-kategori', [KategoriController::class, 'create'])->name('kategori.create');
    Route::get('/barang/tambah-barang', [BarangController::class, 'create'])->name('barang.create');
});