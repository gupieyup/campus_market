<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengunjung\HomeController;
use App\Http\Controllers\Pengunjung\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Seller\DashboardController;

// Halaman cetak laporan (dari DB)
Route::get('/dashboard-seller/cetaklaporan', [\App\Http\Controllers\Seller\ReportController::class, 'index'])
    ->name('seller.cetaklaporan')
    ->middleware('auth');


// Route ke halaman Home Pengunjung (via controller)
Route::get('/', [HomeController::class, 'index']);

// Product listing / search page
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Product detail page
Route::get('/detailproduk/{id}', [ProductController::class, 'show'])->name('products.show');

// Route ke halaman Home Pengunjung
Route::get('/detailproduk', function () {
    // Artinya: Buka file "home" yang ada di dalam folder "pengunjung"
    return view('pengunjung.detailproduk');
});

Route::get('/login-seller', [AuthController::class, 'showLogin']);

// Login / Logout
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/register-seller', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('pengunjung.register');
});

// Seller Dashboard (protected)
Route::get('/dashboard-seller', [DashboardController::class, 'index'])
    ->name('seller.dashboard')
    ->middleware('auth');

Route::get('/dashboard-seller/statistics', [DashboardController::class, 'statistics'])
    ->name('seller.statistics')
    ->middleware('auth');

Route::get('/dashboard-seller/produk', [\App\Http\Controllers\Seller\ProductController::class, 'index'])
    ->name('seller.produk')
    ->middleware('auth');
// Halaman tambah produk (form)
Route::get('/dashboard-seller/tambahproduk', [\App\Http\Controllers\Seller\ProductController::class, 'create'])
    ->name('seller.tambahproduk')
    ->middleware('auth');
// Simpan produk baru
Route::post('/dashboard-seller/produk', [\App\Http\Controllers\Seller\ProductController::class, 'store'])
    ->name('seller.produk.store')
    ->middleware('auth');
// Hapus produk
Route::delete('/dashboard-seller/produk/{id}', [\App\Http\Controllers\Seller\ProductController::class, 'destroy'])
    ->name('seller.produk.destroy')
    ->middleware('auth');
// Toggle aktif/nonaktif produk (POST)
Route::post('/dashboard-seller/produk/{id}/toggle', [\App\Http\Controllers\Seller\ProductController::class, 'toggleActive'])
    ->name('seller.produk.toggle')
    ->middleware('auth');
// Edit produk (form)
Route::get('/dashboard-seller/produk/{id}/edit', [\App\Http\Controllers\Seller\ProductController::class, 'edit'])
    ->name('seller.produk.edit')
    ->middleware('auth');
// Update produk
Route::put('/dashboard-seller/produk/{id}', [\App\Http\Controllers\Seller\ProductController::class, 'update'])
    ->name('seller.produk.update')
    ->middleware('auth');

// (route defined earlier using ReportController)

// Admin Dashboard
Route::get('/dashboard-admin', function () {
    return view('admin.dashboard');
});

Route::get('/dashboard-admin/verifikasi', function () {
    return view('admin.verifikasi.verifikasi');
});

Route::get('/dashboard-admin/detailverifikasi', function () {
    return view('admin.verifikasi.detailverifikasi');
});

Route::get('/dashboard-admin/seller-data', function () {
    return view('admin.penjual.seller_data');
});

Route::get('/dashboard-admin/reports', function () {
    return view('admin.laporan.laporan');
});

// Demo product detail (frontend-only) - no DB required
Route::get('/detailproduk/demo', function () {
    return view('pengunjung.detailproduk', compact('product', 'relatedProducts', 'reviews'));
});
