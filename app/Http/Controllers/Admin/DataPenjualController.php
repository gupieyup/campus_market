<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPenjualController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $search = $request->get('search', '');
        $status = $request->get('status', 'all');

        // Build query
        $query = Seller::with(['user', 'region', 'products']);

        // Apply search filter - HANYA AWALAN
        if ($search) {
            $query->where(function($q) use ($search) {
                // Cari nama toko yang berawalan dengan kata kunci
                $q->where('shop_name', 'like', "{$search}%")
                  // ATAU cari nama user yang berawalan dengan kata kunci
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "{$search}%")
                                // ATAU email yang berawalan dengan kata kunci
                                ->orWhere('email', 'like', "{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($status !== 'all') {
            $isActive = $status === 'active' ? 1 : 0;
            $query->where('is_active', $isActive);
        }

        // Get sellers with pagination
        $sellers = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate stats
        $totalSellers = Seller::count();
        $activeSellers = Seller::where('is_active', true)->count();
        $inactiveSellers = Seller::where('is_active', false)->count();

        // For each seller, calculate additional data
        foreach ($sellers as $seller) {
            // Count products
            $seller->product_count = $seller->products()->count();
            
            // Calculate average rating (assuming you have ratings relationship)
            $avgRating = DB::table('rating_reviews')
                ->join('product_details', 'rating_reviews.product_detail_id', '=', 'product_details.id')
                ->join('products', 'product_details.product_id', '=', 'products.id')
                ->where('products.seller_id', $seller->id)
                ->avg('rating_reviews.rating');
            
            $seller->avg_rating = $avgRating ? round($avgRating, 1) : 0;

            // Calculate total sales (you can modify this based on your orders table)
            // For now, using a simple calculation: price * stock of all products
            $totalSales = $seller->products()
                ->where('is_active', true)
                ->sum(DB::raw('price * stock'));
            
            $seller->total_sales = $totalSales;
        }

        return view('admin.penjual.seller_data', compact(
            'sellers',
            'totalSellers',
            'activeSellers',
            'inactiveSellers',
            'search',
            'status'
        ));
    }

    public function toggleStatus(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        $seller->is_active = !$seller->is_active;
        $seller->save();

        return response()->json([
            'success' => true,
            'message' => $seller->is_active ? 'Penjual berhasil diaktifkan' : 'Penjual berhasil dinonaktifkan',
            'status' => $seller->is_active ? 'active' : 'inactive'
        ]);
    }

    public function export()
    {
        $sellers = Seller::with(['user', 'region', 'products'])->get();
        
        $filename = 'data_penjual_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($sellers) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, ['ID', 'Nama', 'Email', 'Nama Toko', 'Alamat', 'Telepon', 'Provinsi', 'Jumlah Produk', 'Status']);
            
            // Data rows
            foreach ($sellers as $seller) {
                fputcsv($file, [
                    $seller->id,
                    $seller->user->name ?? '-',
                    $seller->user->email ?? '-',
                    $seller->shop_name,
                    $seller->address,
                    $seller->phone,
                    $seller->region->name ?? '-',
                    $seller->products->count(),
                    $seller->is_active ? 'Aktif' : 'Tidak Aktif'
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}