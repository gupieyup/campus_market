<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengunjung\HomeController;
use App\Http\Controllers\Pengunjung\ProductController;
use App\Http\Controllers\Pengunjung\RatingController;
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
// AJAX: Cities by selected province for sidebar search
Route::get('/regions/cities', [ProductController::class, 'cities'])->name('regions.cities');

// Product detail page
Route::get('/detailproduk/{id}', [ProductController::class, 'show'])->name('products.show');

// Ratings: submit review (one per product per email)
Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

Route::get('/login-seller', [AuthController::class, 'showLogin']);

// Login / Logout
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register-seller', function () {
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

// Toggle seller account active/inactive
Route::post('/dashboard-seller/toggle-account', [DashboardController::class, 'toggleAccount'])
    ->name('seller.toggle-account')
    ->middleware('auth');

// Admin Dashboard
Route::get('/dashboard-admin', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware('auth');

Route::get('/dashboard-admin/verifikasi', function () {
    return view('admin.verifikasi.verifikasi');
})->middleware('auth');

Route::get('/dashboard-admin/detailverifikasi', function () {
    return view('admin.verifikasi.detailverifikasi');
})->middleware('auth');

// Data Penjual Routes - UPDATED
Route::get('/dashboard-admin/seller-data', [\App\Http\Controllers\Admin\DataPenjualController::class, 'index'])
    ->name('admin.sellers.index')
    ->middleware('auth');

Route::post('/dashboard-admin/seller-data/{id}/toggle', [\App\Http\Controllers\Admin\DataPenjualController::class, 'toggleStatus'])
    ->name('admin.sellers.toggle')
    ->middleware('auth');

Route::get('/dashboard-admin/seller-data/export', [\App\Http\Controllers\Admin\DataPenjualController::class, 'export'])
    ->name('admin.sellers.export')
    ->middleware('auth');

Route::get('/dashboard-admin/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])
    ->name('admin.reports')
    ->middleware('auth');

require __DIR__.'/debug_ratings.php';