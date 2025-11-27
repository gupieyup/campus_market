<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Seller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $seller = $user->seller;

        if (!$seller) {
            // Handle case where user is not a seller, maybe redirect or show an error
            return redirect('/')->with('error', 'You are not registered as a seller.');
        }

        // Summary metrics for dashboard cards
        $totalProducts = $seller->products()->count();
        $productGrowth = 12.5; // Dummy, replace with real calculation if needed
        $totalStores = Seller::count();
        $storeGrowth = 5.2; // Dummy, replace with real calculation if needed
        $totalReviews = Rating::whereIn('product_id', $seller->products()->pluck('id'))->count();
        $activeCategories = 5; // Dummy value, adjust if you add categories table

        // Seller status
        $activeSellers = 1; // Dummy value, adjust if you add status column
        $inactiveSellers = 0; // Dummy value, adjust if you add status column

        // Province store distribution (dummy data, replace with real query)
        $provinceStores = [
            [ 'initial' => 'JB', 'name' => 'Jawa Barat', 'count' => 120, 'percentage' => 70, 'color' => '#DBEAFE', 'textColor' => '#3B82F6', 'barColor' => '#3B82F6' ],
            [ 'initial' => 'JK', 'name' => 'DKI Jakarta', 'count' => 95, 'percentage' => 55, 'color' => '#FEF3C7', 'textColor' => '#F59E42', 'barColor' => '#F59E42' ],
            [ 'initial' => 'JT', 'name' => 'Jawa Tengah', 'count' => 68, 'percentage' => 40, 'color' => '#D1FAE5', 'textColor' => '#10B981', 'barColor' => '#10B981' ],
            [ 'initial' => 'JI', 'name' => 'Jawa Timur', 'count' => 45, 'percentage' => 35, 'color' => '#E9D5FF', 'textColor' => '#8B5CF6', 'barColor' => '#8B5CF6' ],
            [ 'initial' => 'YO', 'name' => 'Yogyakarta', 'count' => 14, 'percentage' => 20, 'color' => '#FECACA', 'textColor' => '#EF4444', 'barColor' => '#EF4444' ],
        ];

        // Category chart data (dummy, replace with real query)
        $categoryLabels = ['Elektronik', 'Buku', 'Fashion', 'Makanan', 'Hobi', 'Jasa'];
        $categoryData = [450, 780, 520, 300, 200, 150];

        return view('seller.dashboard', [
            'totalProducts' => $totalProducts,
            'productGrowth' => $productGrowth,
            'totalStores' => $totalStores,
            'storeGrowth' => $storeGrowth,
            'totalReviews' => $totalReviews,
            'activeCategories' => $activeCategories,
            'activeSellers' => $activeSellers,
            'inactiveSellers' => $inactiveSellers,
            'provinceStores' => $provinceStores,
            'categoryLabels' => $categoryLabels,
            'categoryData' => $categoryData,
        ]);
    }
}
