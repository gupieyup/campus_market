<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LaporanController;

// API Routes untuk Laporan Admin
Route::prefix('laporan')->group(function () {
    Route::get('/seller-status', [LaporanController::class, 'getSellerStatus']);
    Route::get('/store-location', [LaporanController::class, 'getStoreLocation']);
    Route::get('/product-rating', [LaporanController::class, 'getProductRating']);
});

// Note: Tambahkan route ini ke web.php (bukan api.php) untuk download PDF:
// Route::get('/dashboard-admin/reports/download/{type}', [LaporanController::class, 'downloadPDF'])
//     ->middleware('auth')
//     ->name('admin.reports.download');