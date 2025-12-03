<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $categoryId = $request->query('category');
        try {
            $perPage = 12;

            $productsQuery = Product::with(['seller', 'ratings', 'category']);

            if (!empty($q)) {
                $productsQuery = $productsQuery->where(function ($w) use ($q) {
                    $w->where('name', 'like', '%' . $q . '%')
                      ->orWhereHas('seller', function ($s) use ($q) {
                          $s->where('shop_name', 'like', '%' . $q . '%');
                      });
                });
            }

            // Filter by category if requested (expects category id)
            if (!empty($categoryId)) {
                $productsQuery = $productsQuery->where('category_id', $categoryId);
            }

            $products = $productsQuery->latest()->paginate($perPage);

            $products->getCollection()->transform(function ($p) {
                $avg = $p->ratings->count() ? round($p->ratings->avg('rating'), 1) : 4.8;
                return [
                    'name' => $p->name,
                    'price' => 'Rp ' . number_format($p->price ?? 0, 0, ',', '.'),
                    'location' => $p->seller->province ?? ($p->seller->address ?? 'Lokasi'),
                    'rating' => $avg,
                    'sold' => property_exists($p, 'sold') ? ($p->sold ?? '0') : '0',
                    'img' => $p->image ? asset('storage/' . $p->image) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&q=80',
                ];
            });

        } catch (QueryException $e) {
            // Demo fallback: small list wrapped in paginator
            $items = [
                ['name' => 'Laptop Gaming ASUS ROG Bekas Mulus', 'price' => 'Rp 8.500.000', 'location' => 'Jakarta Selatan', 'rating' => '4.8', 'sold' => '12', 'img' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=500&q=80'],
                ['name' => 'Kemeja Flannel Uniqlo Size L', 'price' => 'Rp 150.000', 'location' => 'Bandung', 'rating' => '4.9', 'sold' => '5', 'img' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&q=80'],
            ];

            $perPage = 12;
            $page = max(1, (int) $request->query('page', 1));

            $products = new LengthAwarePaginator(array_slice($items, ($page - 1) * $perPage, $perPage), count($items), $perPage, $page, [
                'path' => url()->current(),
                'query' => $request->query(),
            ]);
        }

        return view('pengunjung.products', [
            'products' => $products,
            'q' => $q,
            'categories' => Category::all(),
            'activeCategory' => $categoryId,
        ]);
    }
}
