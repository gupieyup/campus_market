<?php

use Illuminate\Support\Facades\Route;


// Route ke halaman Home Pengunjung
Route::get('/', function () {
    // Artinya: Buka file "home" yang ada di dalam folder "pengunjung"
    return view('pengunjung.home');
});

Route::get('/login-seller', function () {
    // Artinya: Buka file "home" yang ada di dalam folder "pengunjung"
    return view('pengunjung.login');
});

Route::get('/register-seller', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('pengunjung.register');
});

Route::get('/dashboard-admin', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('admin.dashboard');
});

Route::get('/dashboard-admin/verifikasi', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('admin.verifikasi.verifikasi');
});

Route::get('/dashboard-admin/detailverifikasi', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('admin.verifikasi.detailverifikasi');
});

Route::get('/dashboard-admin/seller-data', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('admin.penjual.seller_data');
});


Route::get('/dashboard-admin/reports', function () {
    // Artinya: Buka file "register" yang ada di dalam folder "pengunjung"
    return view('admin.produk.produk');
});