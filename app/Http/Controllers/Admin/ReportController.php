<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Region;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $generatedAt = now();
        $processedBy = optional(auth()->user())->name ?? 'Admin';

        // SRS-MartPlace-09: Sellers by status (Aktif first)
        $sellers = Seller::with(['user'])
            ->select(['id','user_id','shop_name','is_active'])
            ->get();

        $sellersByStatus = $sellers->map(function ($s) {
            return [
                'user_name' => optional($s->user)->name,
                'pic_name' => optional($s->user)->name, // using user as PIC
                'store_name' => $s->shop_name,
                'status' => $s->is_active ? 'Aktif' : 'Tidak Aktif',
            ];
        })->sortByDesc(function ($row) {
            return strtolower($row['status']) === 'aktif';
        })->values()->all();

        // SRS-MartPlace-10: Stores by province (sorted)
        $stores = Seller::with(['region','user'])
            ->select(['id','shop_name','region_id','user_id'])
            ->get();

        $storesByProvince = $stores->map(function ($s) {
            return [
                'store_name' => $s->shop_name,
                'pic_name' => optional($s->user)->name,
                'province' => optional($s->region)->name,
            ];
        })->sortBy(function ($row) {
            return $row['province'] ?? '';
        })->values()->all();

        // SRS-MartPlace-11: Products by rating (desc), province is rater's province
        $products = Product::with(['category','seller','ratings.region'])
            ->select(['id','seller_id','name','price','category_id'])
            ->get();

        $productsByRating = $products->map(function ($p) {
            $avgRating = round(optional($p->ratings)->avg('rating'), 2);
            // Choose province of the latest rating if available
            $latestRating = optional($p->ratings)->sortByDesc('id')->first();
            $province = optional(optional($latestRating)->region)->name;
            return [
                'product_name' => $p->name,
                'category' => optional($p->category)->name,
                'price' => $p->price,
                'rating' => $avgRating ?: 0,
                'store_name' => optional($p->seller)->shop_name,
                'province' => $province,
            ];
        })->sortByDesc(function ($row) {
            return $row['rating'] ?? 0;
        })->values()->all();

        return view('admin.laporan.laporan', [
            'generatedAt' => $generatedAt,
            'processedBy' => $processedBy,
            'sellersByStatus' => $sellersByStatus,
            'storesByProvince' => $storesByProvince,
            'productsByRating' => $productsByRating,
        ]);
    }
}
