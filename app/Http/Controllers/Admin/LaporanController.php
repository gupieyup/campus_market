<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\Log;

class LaporanController extends Controller
{
    // // ============================================
    // // VIEW LAPORAN
    // // ============================================
    // public function index()
    // {
    //     return view('admin.laporan.laporan');  
    // }

    // // ============================================
    // // API 1 — SELLER STATUS
    // // ============================================
    // public function getSellerStatus()
    // {
    //     try {
    //         $sellers = Seller::with(['user', 'region'])->get();

    //         $data = $sellers->map(function ($s) {
    //             return [
    //                 'seller'     => $s->user->name ?? '-',
    //                 'shop_name'  => $s->shop_name ?? '-',
    //                 'is_active'  => $s->is_active ? 'Aktif' : 'Nonaktif',
    //                 'region'     => $s->region->name ?? '-',
    //                 'phone'      => $s->phone ?? '-',
    //                 'address'    => $s->address ?? '-',
    //             ];
    //         });

    //         return response()->json($data);
    //     } catch (\Exception $e) {
    //         Log::error('Error in getSellerStatus: ' . $e->getMessage());
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    // // ============================================
    // // API 2 — STORE LOCATION
    // // ============================================
    // public function getStoreLocation()
    // {
    //     try {
    //         $sellers = Seller::with(['user', 'region'])->get();

    //         $data = $sellers->map(function ($s) {
    //             return [
    //                 'shop_name' => $s->shop_name ?? '-',
    //                 'seller'    => $s->user->name ?? '-',
    //                 'region'    => $s->region->name ?? '-',
    //                 'address'   => $s->address ?? '-',
    //                 'phone'     => $s->phone ?? '-',
    //             ];
    //         });

    //         return response()->json($data);
    //     } catch (\Exception $e) {
    //         Log::error('Error in getStoreLocation: ' . $e->getMessage());
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    // // ============================================
    // // API 3 — PRODUCT RATING
    // // ============================================
    // public function getProductRating()
    // {
    //     try {
    //         // Ambil rating dengan relasi yang lengkap
    //         $ratings = Rating::with([
    //             'productDetail.product.category',
    //             'productDetail.product.seller.user',
    //             'productDetail.product.seller.region'
    //         ])->get();

    //         $data = $ratings->map(function ($r) {
    //             // Pastikan product detail dan product ada
    //             $product = $r->productDetail->product ?? null;
                
    //             return [
    //                 'product'   => $product->name ?? '-',
    //                 'category'  => $product->category->name ?? '-',
    //                 'rating'    => $r->rating ?? 0,
    //                 'review'    => $r->review ?? '-',
    //                 'seller'    => $product->seller->user->name ?? '-',
    //                 'shop_name' => $product->seller->shop_name ?? '-',
    //                 'region'    => $product->seller->region->name ?? '-',
    //             ];
    //         });

    //         return response()->json($data);
    //     } catch (\Exception $e) {
    //         Log::error('Error in getProductRating: ' . $e->getMessage());
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    // // ============================================
    // // DOWNLOAD PDF
    // // ============================================
    // public function downloadPDF($type)
    // {
    //     try {
    //         $data = [];
    //         $title = '';
            
    //         switch($type) {
    //             case 'seller_status':
    //                 $sellers = Seller::with(['user', 'region'])->get();
    //                 $data = $sellers->map(function ($s) {
    //                     return [
    //                         'seller'     => $s->user->name ?? '-',
    //                         'shop_name'  => $s->shop_name ?? '-',
    //                         'is_active'  => $s->is_active ? 'Aktif' : 'Nonaktif',
    //                         'region'     => $s->region->name ?? '-',
    //                         'phone'      => $s->phone ?? '-',
    //                         'address'    => $s->address ?? '-',
    //                     ];
    //                 })->toArray();
    //                 $title = 'Laporan Akun Penjual';
    //                 break;
                    
    //             case 'store_location':
    //                 $sellers = Seller::with(['user', 'region'])->get();
    //                 $data = $sellers->map(function ($s) {
    //                     return [
    //                         'shop_name' => $s->shop_name ?? '-',
    //                         'seller'    => $s->user->name ?? '-',
    //                         'region'    => $s->region->name ?? '-',
    //                         'address'   => $s->address ?? '-',
    //                         'phone'     => $s->phone ?? '-',
    //                     ];
    //                 })->toArray();
    //                 $title = 'Laporan Daftar Toko per Lokasi';
    //                 break;
                    
    //             case 'product_rating':
    //                 $ratings = Rating::with([
    //                     'productDetail.product.category',
    //                     'productDetail.product.seller.user',
    //                     'productDetail.product.seller.region'
    //                 ])->get();
    //                 $data = $ratings->map(function ($r) {
    //                     $product = $r->productDetail->product ?? null;
    //                     return [
    //                         'product'   => $product->name ?? '-',
    //                         'category'  => $product->category->name ?? '-',
    //                         'rating'    => $r->rating ?? 0,
    //                         'review'    => $r->review ?? '-',
    //                         'seller'    => $product->seller->user->name ?? '-',
    //                         'shop_name' => $product->seller->shop_name ?? '-',
    //                         'region'    => $product->seller->region->name ?? '-',
    //                     ];
    //                 })->toArray();
    //                 $title = 'Laporan Produk Berdasarkan Rating';
    //                 break;
    //         }

    //         $pdf = PDF::loadView('admin.laporan.pdf', [
    //             'data' => $data,
    //             'title' => $title,
    //             'type' => $type,
    //             'date' => now()->format('d F Y')
    //         ]);

    //         return $pdf->download('laporan_' . $type . '_' . now()->format('YmdHis') . '.pdf');
            
    //     } catch (\Exception $e) {
    //         Log::error('Error in downloadPDF: ' . $e->getMessage());
    //         return back()->with('error', 'Gagal mengunduh PDF: ' . $e->getMessage());
    //     }
    // }
}