<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ProductDetail;
use App\Models\Rating;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    /**
     * Display the specified product detail.
     */
    public function show(Request $request, $id)
    {
        try {
            $product = Product::with(['seller', 'category', 'productDetails'])->findOrFail($id);
    
            // >>> tambahkan blok ini <<<
            $img = $product->image;
            if ($img) {
                if (filter_var($img, FILTER_VALIDATE_URL)) {
                    // kalau sudah full URL (unsplash, dll)
                    $imageUrl = $img;
                } elseif (Str::startsWith($img, 'images/')) {
                    // kalau path-nya "images/...." (public/images)
                    $imageUrl = asset($img);
                } else {
                    // default: anggap disimpan di storage
                    $imageUrl = asset('storage/' . ltrim($img, '/'));
                }
            } else {
                // fallback kalau kosong
                $imageUrl = 'https://via.placeholder.com/600x600?text=No+Image';
            }
            $product->image_url = $imageUrl;
            // >>> sampai sini <<<
    
            // description, shop, relatedProducts, reviews ... (kode kamu yang lama)
            $firstDetail = $product->productDetails->first();
            $product->description = $firstDetail->description ?? ($product->description ?? null);
    
            $product->shop = (object) ['name' => $product->seller->shop_name ?? ($product->seller->user->name ?? 'Toko')];
    
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->take(6)
                ->get();
    
            $detailIds = $product->productDetails->pluck('id')->all();
            $reviews = Rating::whereIn('product_detail_id', $detailIds)
                ->orderByDesc('created_at')
                ->get()
                ->map(function ($r) {
                    return (object) [
                        'user_name' => $r->name ?? 'Pembeli',
                        'rating'    => $r->rating,
                        'comment'   => $r->review,
                        'created_at'=> $r->created_at,
                    ];
                });
    
            return view('pengunjung.detailproduk', compact('product', 'relatedProducts', 'reviews'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }
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

            if (!empty($categoryId)) {
                $productsQuery = $productsQuery->where('category_id', $categoryId);
            }

            $products = $productsQuery->latest()->paginate($perPage);

            // SAMAKAN FORMAT DENGAN HomeController + tambahkan URL
            $products->getCollection()->transform(function ($p) {
                $avg = $p->ratings->count() ? round($p->ratings->avg('rating'), 1) : 4.8;

                return [
                    'id'       => $p->id,
                    'url'      => route('products.show', $p->id),
                    'name'     => $p->name,
                    'price'    => 'Rp ' . number_format($p->price ?? 0, 0, ',', '.'),
                    'location' => $p->seller->region->name 
                                ?? $p->seller->region->region_name 
                                ?? 'Tidak diketahui',
                    'rating'   => $avg,
                    'sold'     => property_exists($p, 'sold') ? ($p->sold ?? '0') : '0',
                    'img'      => function_exists('asset') ? (
                        filter_var($p->image, FILTER_VALIDATE_URL)
                            ? $p->image
                            : (
                                Str::startsWith($p->image, 'images/')
                                    ? asset($p->image)
                                    : asset('storage/' . ltrim($p->image, '/'))
                            )
                    ) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&q=80',
                ];
            });

        } catch (QueryException $e) {
            // fallback demo
            $items = [
                [
                    'id'       => 1,
                    'url'      => '#',
                    'name'     => 'Laptop Gaming ASUS ROG Bekas Mulus',
                    'price'    => 'Rp 8.500.000',
                    'location' => 'Jakarta Selatan',
                    'rating'   => '4.8',
                    'sold'     => '12',
                    'img'      => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=500&q=80',
                ],
                [
                    'id'       => 2,
                    'url'      => '#',
                    'name'     => 'Kemeja Flannel Uniqlo Size L',
                    'price'    => 'Rp 150.000',
                    'location' => 'Bandung',
                    'rating'   => '4.9',
                    'sold'     => '5',
                    'img'      => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&q=80',
                ],
            ];

            $perPage = 12;
            $page = max(1, (int) $request->query('page', 1));

            $products = new LengthAwarePaginator(
                array_slice($items, ($page - 1) * $perPage, $perPage),
                count($items),
                $perPage,
                $page,
                [
                    'path'  => url()->current(),
                    'query' => $request->query(),
                ]
            );
        }

        return view('pengunjung.products', [
            'products'       => $products,
            'q'              => $q,
            'categories'     => Category::all(),
            'activeCategory' => $categoryId,
        ]);
    }
}