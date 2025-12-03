<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengunjung\HomeController;
use App\Http\Controllers\Pengunjung\ProductController;

// Halaman cetak laporan
Route::get('/dashboard-seller/cetaklaporan', function () {
    return view('seller.cetaklaporan');
})->name('seller.cetaklaporan');

// Halaman tambah produk
Route::get('/dashboard-seller/tambahproduk', function () {
    return view('seller.tambahproduk');
})->name('seller.tambahproduk');


// Route ke halaman Home Pengunjung (via controller)
Route::get('/', [HomeController::class, 'index']);

// Product listing / search page
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Route ke halaman Home Pengunjung
Route::get('/detailproduk', function () {
    // Artinya: Buka file "home" yang ada di dalam folder "pengunjung"
    return view('pengunjung.detailproduk');
});

Route::get('/login-seller', function () {
    // Artinya: Buka file "home" yang ada di dalam folder "pengunjung"
    return view('pengunjung.login');
});


Route::get('/register-seller', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('pengunjung.register');
});

// Seller Dashboard
Route::get('/dashboard-seller', function () {
    return view('seller.dashboard');
})->name('seller.dashboard');

Route::get('/dashboard-seller/statistics', function () {
    return view('seller.statistics');
})->name('seller.statistics');

Route::get('/dashboard-seller/produk', function () {
    return view('seller.produk');
})->name('seller.produk');

// Halaman tambah produk
Route::get('/dashboard-seller/tambahproduk', function () {
    return view('seller.tambahproduk');
})->name('seller.tambahproduk');

// Halaman cetak laporan
Route::get('/dashboard-seller/cetaklaporan', function () {
    return view('seller.cetaklaporan');
})->name('seller.cetaklaporan');

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
