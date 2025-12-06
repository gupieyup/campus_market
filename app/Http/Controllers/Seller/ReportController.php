<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Rating;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $seller = $user ? $user->seller : null;

        if (!$seller) {
            return view('seller.cetaklaporan', [
                'noSeller' => true,
                'stockSorted' => [],
                'ratingSorted' => [],
                'critical' => [],
                'generatedAt' => now(),
            ]);
        }

        $products = Product::where('seller_id', $seller->id)
            ->with('category')
            ->get();

        $productIds = $products->pluck('id')->toArray();

        // Fetch rating aggregates by joining rating_reviews -> product_details to group by product_id
        $ratingAgg = DB::table('rating_reviews')
            ->join('product_details', 'rating_reviews.product_detail_id', '=', 'product_details.id')
            ->whereIn('product_details.product_id', $productIds)
            ->select('product_details.product_id as product_id', DB::raw('AVG(rating_reviews.rating) as avg_rating'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('product_details.product_id')
            ->get()
            ->keyBy('product_id');

        $items = $products->map(function ($p) use ($ratingAgg) {
            $agg = $ratingAgg->get($p->id);
            $avg = $agg ? round((float) $agg->avg_rating, 2) : 0.0;
            $count = $agg ? (int) $agg->cnt : 0;

            return [
                'id' => $p->id,
                'name' => $p->name,
                'category' => $p->category ? $p->category->name : '-',
                'price' => (int) $p->price,
                'stock' => (int) $p->stock,
                'rating' => $avg,
                'rating_count' => $count,
            ];
        })->toArray();

        // Sort for reports
        $stockSorted = collect($items)->sortByDesc('stock')->values()->all();
        $ratingSorted = collect($items)->sortByDesc('rating')->values()->all();
        $critical = collect($items)->filter(fn($i) => $i['stock'] < 2)->values()->all();

        return view('seller.cetaklaporan', [
            'noSeller' => false,
            'stockSorted' => $stockSorted,
            'ratingSorted' => $ratingSorted,
            'critical' => $critical,
            'generatedAt' => now(),
        ]);
    }
}
