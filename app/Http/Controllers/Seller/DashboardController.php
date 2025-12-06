<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Seller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $seller = $user->seller;

        $noSeller = false;
        if (!$seller) {
            $noSeller = true;
            // pass defaults to view
            return view('seller.dashboard', [
                'noSeller' => $noSeller,
                'totalProducts' => 0,
                'totalStock' => 0,
                'totalSales' => 0,
                'avgRating' => 0,
                'ratingCount' => 0,
                'pendingOrders' => 0,
                'topStockProducts' => [],
                'ratingDistribution' => [0,0,0,0,0],
                'provinceDistribution' => [],
            ]);
        }

        // Summary metrics for dashboard cards (real queries)
        $productIds = $seller->products()->pluck('id');
        $totalProducts = $productIds->count();
        $totalStock = Product::where('seller_id', $seller->id)->sum('stock');

        // Total sales (distinct orders that include this seller's products)
        $totalSales = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller->id)
            ->distinct()
            ->count('orders.id');

        // Pending orders (status diproses)
        $pendingOrders = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller->id)
            ->where('orders.status', 'diproses')
            ->distinct()
            ->count('orders.id');

        // Today's new orders
        $ordersToday = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller->id)
            ->whereDate('orders.created_at', now()->toDateString())
            ->distinct()
            ->count('orders.id');

        // Ratings: rating_reviews references product_detail_id, so map product -> product_details -> ratings
        $productDetailIds = \App\Models\ProductDetail::whereIn('product_id', $productIds)->pluck('id');
        $ratingCount = Rating::whereIn('product_detail_id', $productDetailIds)->count();
        $avgRating = Rating::whereIn('product_detail_id', $productDetailIds)->avg('rating') ?? 0;
        $avgRating = round($avgRating, 2);

        // Top 5 products by stock (for chart)
        $topStockProducts = Product::where('seller_id', $seller->id)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get(['name', 'stock'])
            ->map(function ($p) {
                return ['name' => $p->name, 'stock' => (int) $p->stock];
            })->toArray();

        // Top selling product id for rating distribution
        $topProduct = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller->id)
            ->select('products.id', DB::raw('SUM(order_items.qty) as sold'))
            ->groupBy('products.id')
            ->orderByDesc('sold')
            ->first();

        $ratingDistribution = [0,0,0,0,0];
        if ($topProduct) {
            // find product_detail ids for top product and aggregate ratings across them
            $topDetailIds = \App\Models\ProductDetail::where('product_id', $topProduct->id)->pluck('id');
            $counts = Rating::whereIn('product_detail_id', $topDetailIds)
                ->select('rating', DB::raw('count(*) as count'))
                ->groupBy('rating')
                ->pluck('count', 'rating')
                ->toArray();
            // rating keys might be 1..5
            for ($r = 5; $r >= 1; $r--) {
                $ratingDistribution[5 - $r] = isset($counts[$r]) ? (int) $counts[$r] : 0;
            }
        }

        $topProductName = null;
        if ($topProduct) {
            $prod = Product::find($topProduct->id);
            $topProductName = $prod ? $prod->name : null;
        }

        // Sebaran pemberi rating per provinsi (top 6)
        // rating_reviews stores region_id; join region to get region.name
        $provinceDistribution = DB::table('rating_reviews')
            ->join('product_details', 'rating_reviews.product_detail_id', '=', 'product_details.id')
            ->join('region', 'rating_reviews.region_id', '=', 'region.id')
            ->whereIn('product_details.product_id', $productIds)
            ->select('region.name as province', DB::raw('COUNT(*) as count'))
            ->groupBy('region.name')
            ->orderByDesc('count')
            ->limit(6)
            ->get()
            ->map(function ($r) {
                return ['province' => $r->province ?? '-', 'count' => (int) $r->count];
            })->toArray();

        return view('seller.dashboard', [
            'noSeller' => $noSeller,
            'totalProducts' => $totalProducts,
            'totalStock' => $totalStock,
            'totalSales' => $totalSales,
            'avgRating' => $avgRating,
            'ratingCount' => $ratingCount,
            'pendingOrders' => $pendingOrders,
            'ordersToday' => $ordersToday,
            'topStockProducts' => $topStockProducts,
            'ratingDistribution' => $ratingDistribution,
            'topProductName' => $topProductName,
            'provinceDistribution' => $provinceDistribution,
        ]);
    }

    /**
     * Menyajikan statistik penjual dari database yang sudah ada.
     * Tidak menambah database baru — memakai tabel `orders`, `order_items`, `products`.
     */
    public function statistics()
    {
        $user = Auth::user();
        $seller = $user->seller;

        $noSeller = false;
        if (!$seller) {
            // Jangan redirect — tampilkan halaman statistik tapi sembunyikan metrik
            $noSeller = true;
        }

        // Rentang 7 hari terakhir
        $labels = [];
        $data = [];
        if (!$noSeller) {
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i)->toDateString();
                $labels[] = $date;
                $total = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('products', 'order_items.product_id', '=', 'products.id')
                    ->where('products.seller_id', $seller->id)
                    ->whereDate('orders.created_at', $date)
                    ->sum('order_items.subtotal');
                $data[] = (int) $total;
            }
        }

        // Minggu sebelumnya (7 hari sebelum range di atas)
        $prevData = [];
        if (!$noSeller) {
            for ($i = 13; $i >= 7; $i--) {
                $date = now()->subDays($i)->toDateString();
                $total = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('products', 'order_items.product_id', '=', 'products.id')
                    ->where('products.seller_id', $seller->id)
                    ->whereDate('orders.created_at', $date)
                    ->sum('order_items.subtotal');
                $prevData[] = (int) $total;
            }
        }

        // Pesanan baru 7 hari terakhir (unique orders containing seller products)
        if (!$noSeller) {
            $sevenDaysAgo = now()->subDays(7);
            $newOrders = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.seller_id', $seller->id)
                ->where('orders.created_at', '>=', $sevenDaysAgo)
                ->distinct()
                ->count('orders.id');

            // Produk terjual (jumlah qty untuk produk seller)
            $productsSold = (int) DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.seller_id', $seller->id)
                ->sum('order_items.qty');

            // Pendapatan bersih total (sum subtotal untuk produk seller)
            $netRevenue = (int) DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.seller_id', $seller->id)
                ->sum('order_items.subtotal');

            // Ranking produk (top 5 berdasarkan jumlah terjual)
            $productRankings = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.seller_id', $seller->id)
                ->select('products.id', 'products.name', DB::raw('SUM(order_items.qty) as sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('sold')
                ->limit(5)
                ->get()
                ->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'sold' => (int) $p->sold,
                        'image' => 'https://placehold.co/40x40/10B981/FFFFFF?text=' . urlencode(substr($p->name, 0, 2)),
                    ];
                })->toArray();

            // Pendapatan hari ini
            $todayRevenue = (int) DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.seller_id', $seller->id)
                ->whereDate('orders.created_at', now()->toDateString())
                ->sum('order_items.subtotal');

            $prevWeekTotal = array_sum($prevData);
        } else {
            // Default kosong jika bukan seller
            $newOrders = 0;
            $productsSold = 0;
            $netRevenue = 0;
            $productRankings = [];
            $todayRevenue = 0;
            $prevWeekTotal = 0;
        }

        return view('seller.statistics', [
            'newOrders' => $newOrders,
            'productsSold' => $productsSold,
            'netRevenue' => $netRevenue,
            'productRankings' => $productRankings,
            'labels' => $labels,
            'data' => $data,
            'prevData' => $prevData,
            'todayRevenue' => $todayRevenue,
            'prevWeekTotal' => $prevWeekTotal,
        ]);
    }
}
