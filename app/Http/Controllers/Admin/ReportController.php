<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Region;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $generatedAt = now();
            $processedBy = auth()->check() && auth()->user()->name 
                ? auth()->user()->name 
                : 'Admin';

            // SRS-MartPlace-09: Sellers by status (Aktif first)
            $sellers = Seller::with('user')
                ->get();

            $sellersByStatus = $sellers->map(function ($seller) {
                return [
                    'user_name' => $seller->user ? $seller->user->name : 'N/A',
                    'pic_name' => $seller->user ? $seller->user->name : 'N/A',
                    'store_name' => $seller->shop_name ?? 'N/A',
                    'status' => $seller->is_active ? 'Aktif' : 'Tidak Aktif',
                ];
            })->sortByDesc(function ($row) {
                return strtolower($row['status']) === 'aktif' ? 1 : 0;
            })->values()->all();

            // SRS-MartPlace-10: Stores by province (sorted)
            $stores = Seller::with(['region', 'user'])
                ->get();

            $storesByProvince = $stores->map(function ($seller) {
                return [
                    'store_name' => $seller->shop_name ?? 'N/A',
                    'pic_name' => $seller->user ? $seller->user->name : 'N/A',
                    'province' => $seller->region ? $seller->region->name : 'N/A',
                ];
            })->sortBy(function ($row) {
                return $row['province'];
            })->values()->all();

            // SRS-MartPlace-11: Products by rating (desc)
            $products = Product::with([
                    'category',
                    'seller',
                    'ratings.region'
                ])
                ->get();

            $productsByRating = $products->map(function ($product) {
                // Hitung rata-rata rating
                $ratingsCount = $product->ratings->count();
                $avgRating = $ratingsCount > 0 
                    ? round($product->ratings->avg('rating'), 2) 
                    : 0;
                
                // Ambil provinsi dari rating terbaru
                $latestRating = $product->ratings->sortByDesc('id')->first();
                $province = 'N/A';
                
                if ($latestRating && $latestRating->region) {
                    $province = $latestRating->region->name;
                }
                
                return [
                    'product_name' => $product->name ?? 'N/A',
                    'category' => $product->category ? $product->category->name : 'N/A',
                    'price' => $product->price ?? 0,
                    'rating' => $avgRating,
                    'store_name' => $product->seller ? $product->seller->shop_name : 'N/A',
                    'province' => $province,
                ];
            })->sortByDesc(function ($row) {
                return $row['rating'];
            })->values()->all();

            return view('admin.laporan.laporan', [
                'generatedAt' => $generatedAt,
                'processedBy' => $processedBy,
                'sellersByStatus' => $sellersByStatus,
                'storesByProvince' => $storesByProvince,
                'productsByRating' => $productsByRating,
            ]);

        } catch (\Exception $e) {
            Log::error('Report Controller Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return view('admin.laporan.laporan', [
                'generatedAt' => now(),
                'processedBy' => 'Admin',
                'sellersByStatus' => [],
                'storesByProvince' => [],
                'productsByRating' => [],
                'error' => $e->getMessage()
            ]);
        }
    }
}