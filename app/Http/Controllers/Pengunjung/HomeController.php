<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        // Fetch latest products with seller and ratings. If the products table doesn't exist
        // (e.g. migrations haven't been run), catch the exception and return a demo fallback
        // so the frontend can render without crashing.
        try {
            $perPage = 12;
            $page = max(1, (int) $request->query('page', 1));

            $productsQuery = Product::with(['seller', 'ratings']);

            if (!empty($q)) {
                $productsQuery = $productsQuery->where(function ($w) use ($q) {
                    $w->where('name', 'like', '%' . $q . '%')
                      ->orWhereHas('seller', function ($s) use ($q) {
                          $s->where('shop_name', 'like', '%' . $q . '%');
                      });
                });
            }

            // Use paginate so we can render pagination links in the view
            $productsPaginated = $productsQuery->latest()->paginate($perPage);

            // Transform each product into a view-friendly array
            $productsPaginated->getCollection()->transform(function ($p) {
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

            $products = $productsPaginated;
        } catch (QueryException $e) {
            // Demo fallback (matches the previous demo data used in the view)
            $items = [
                ['name' => 'Laptop Gaming ASUS ROG Bekas Mulus', 'price' => 'Rp 8.500.000', 'location' => 'Jakarta Selatan', 'rating' => '4.8', 'sold' => '12', 'img' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=500&q=80'],
                ['name' => 'Kemeja Flannel Uniqlo Size L', 'price' => 'Rp 150.000', 'location' => 'Bandung', 'rating' => '4.9', 'sold' => '5', 'img' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&q=80'],
                ['name' => 'Kalkulus Jilid 1 Purcell Edisi 9', 'price' => 'Rp 80.000', 'location' => 'Semarang', 'rating' => '5.0', 'sold' => '30', 'img' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&q=80'],
                ['name' => 'Sepatu Converse Chuck Taylor 70s', 'price' => 'Rp 450.000', 'location' => 'Surabaya', 'rating' => '4.7', 'sold' => '8', 'img' => 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=500&q=80'],
                ['name' => 'Headphone Sony WH-1000XM4', 'price' => 'Rp 3.200.000', 'location' => 'Jakarta Barat', 'rating' => '4.9', 'sold' => '42', 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=500&q=80'],
                ['name' => 'Skincare Bundle Somethinc', 'price' => 'Rp 199.000', 'location' => 'Yogyakarta', 'rating' => '4.8', 'sold' => '150+', 'img' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=500&q=80'],
                ['name' => 'Totebag Kanvas Aesthetics', 'price' => 'Rp 35.000', 'location' => 'Malang', 'rating' => '4.6', 'sold' => '88', 'img' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=500&q=80'],
                ['name' => 'Mouse Logitech G304 Wireless', 'price' => 'Rp 400.000', 'location' => 'Medan', 'rating' => '4.9', 'sold' => '200+', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&q=80'],
                ['name' => 'Keyboard Keychron K2 V2', 'price' => 'Rp 1.100.000', 'location' => 'Jakarta Pusat', 'rating' => '4.8', 'sold' => '15', 'img' => 'https://images.unsplash.com/photo-1587829741301-dc798b91a603?w=500&q=80'],
                ['name' => 'Meja Belajar Minimalis Ikea', 'price' => 'Rp 250.000', 'location' => 'Bogor', 'rating' => '4.5', 'sold' => '3', 'img' => 'https://images.unsplash.com/photo-1519947486511-4639940be43a?w=500&q=80'],
            ];

            $perPage = 12;
            $page = max(1, (int) $request->query('page', 1));

            $products = new LengthAwarePaginator(array_slice($items, ($page - 1) * $perPage, $perPage), count($items), $perPage, $page, [
                'path' => url()->current(),
                'query' => $request->query(),
            ]);
        }

        // Attempt to load categories from the database. If categories table is missing
        // or another DB error occurs, fall back to a small static list.
        try {
            $categoriesRaw = Category::latest()->take(10)->get();

            // simple icon/color assignment by keyword
            $iconMap = [
                'elektronik' => ['icon' => 'fa-laptop', 'color' => 'bg-blue-100 text-blue-600'],
                'pakaian' => ['icon' => 'fa-shirt', 'color' => 'bg-pink-100 text-pink-600'],
                'perabot' => ['icon' => 'fa-bed', 'color' => 'bg-emerald-100 text-emerald-600'],
                'buku' => ['icon' => 'fa-book', 'color' => 'bg-yellow-100 text-yellow-600'],
                'makanan' => ['icon' => 'fa-utensils', 'color' => 'bg-orange-100 text-orange-600'],
                'kendaraan' => ['icon' => 'fa-bicycle', 'color' => 'bg-indigo-100 text-indigo-600'],
                'kesehatan' => ['icon' => 'fa-heart', 'color' => 'bg-rose-100 text-rose-600'],
                'jasa' => ['icon' => 'fa-briefcase', 'color' => 'bg-purple-100 text-purple-600'],
            ];

            $categories = $categoriesRaw->map(function ($c) use ($iconMap) {
                $name = $c->name;
                $lower = mb_strtolower($name);
                $matched = ['icon' => 'fa-tag', 'color' => 'bg-gray-100 text-gray-600'];
                foreach ($iconMap as $k => $v) {
                    if (str_contains($lower, $k)) {
                        $matched = $v;
                        break;
                    }
                }

                return [
                    'name' => $name,
                    'icon' => $matched['icon'],
                    'color' => $matched['color'],
                ];
            })->toArray();
        } catch (QueryException $e) {
            $categories = [
                ['name' => 'Elektronik & Gadget', 'icon' => 'fa-laptop', 'color' => 'bg-blue-100 text-blue-600'],
                ['name' => 'Pakaian & Aksesoris', 'icon' => 'fa-shirt', 'color' => 'bg-pink-100 text-pink-600'],
                ['name' => 'Perabot Rumah & Dapur', 'icon' => 'fa-bed', 'color' => 'bg-emerald-100 text-emerald-600'],
                ['name' => 'Buku & Media', 'icon' => 'fa-book', 'color' => 'bg-yellow-100 text-yellow-600'],
                ['name' => 'Makanan & Minuman', 'icon' => 'fa-utensils', 'color' => 'bg-orange-100 text-orange-600'],
                ['name' => 'Kendaraan & Aksesoris', 'icon' => 'fa-bicycle', 'color' => 'bg-indigo-100 text-indigo-600'],
                ['name' => 'Kesehatan & Kecantikan', 'icon' => 'fa-heart', 'color' => 'bg-rose-100 text-rose-600'],
                ['name' => 'Jasa & Layanan', 'icon' => 'fa-briefcase', 'color' => 'bg-purple-100 text-purple-600'],
            ];
        }

        return view('pengunjung.home', compact('categories', 'products'));
    }
}
