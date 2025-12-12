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
use App\Models\Region;
use App\Models\Cities;
use App\Models\Seller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display the specified product detail.
     */
    public function show(Request $request, $id)
    {
        try {
            $product = Product::active()
                ->whereHas('seller', function ($s) {
                    $s->where('is_active', true)
                      ->where('verification_status', 'verified');
                })
                ->with(['seller.user', 'seller.region', 'category', 'productDetails'])
                ->findOrFail($id);

            $img = $product->image;
            if ($img) {
                if (filter_var($img, FILTER_VALIDATE_URL)) {
                    $imageUrl = $img;
                } elseif (Str::startsWith($img, 'images/')) {
                    $imageUrl = asset($img);
                } elseif (Str::startsWith($img, '/storage/') || Str::startsWith($img, 'storage/')) {
                    $imageUrl = asset(ltrim($img, '/'));
                } else {
                    $imageUrl = asset('storage/' . ltrim($img, '/'));
                }
            } else {
                $imageUrl = 'https://via.placeholder.com/600x600?text=No+Image';
            }
            $product->image_url = $imageUrl;

            $firstDetail = $product->productDetails->first();
            $firstDetailId = $firstDetail->id ?? null;
            $product->description = $firstDetail->description ?? ($product->description ?? null);

            $product->shop = (object) [
                'name' => ($product->seller->shop_name ?? optional($product->seller->user)->name ?? 'Toko')
            ];

            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->whereHas('seller', function ($s) {
                    $s->where('is_active', true)
                      ->where('verification_status', 'verified');
                })
                ->take(6)
                ->get();

            $detailIds = $product->productDetails->pluck('id')->all();
            $rawReviews = Rating::whereIn('product_detail_id', $detailIds)
                ->orderByDesc('created_at')
                ->get();

            $reviews = $rawReviews->map(function ($r) {
                return (object) [
                    'user_name' => $r->name ?? 'Pembeli',
                    'rating'    => $r->rating,
                    'comment'   => $r->review,
                    'created_at'=> $r->created_at,
                ];
            });

            $avgRating = $rawReviews->count() ? round($rawReviews->avg('rating'), 1) : 0;
            $totalReviews = $rawReviews->count();
            $starCounts = [1=>0,2=>0,3=>0,4=>0,5=>0];
            foreach ($rawReviews as $r) {
                $val = (int) $r->rating;
                if (isset($starCounts[$val])) $starCounts[$val]++;
            }

            return view('pengunjung.detailproduk', compact('product', 'relatedProducts', 'reviews', 'avgRating', 'totalReviews', 'starCounts', 'firstDetailId'));
        } catch (ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function index(Request $request)
    {
        // Read query parameters
        $q         = trim($request->query('q', ''));
        $categoryId= $request->query('category');
        $shopName  = trim($request->query('shop', ''));
        $provinceId= $request->query('province');
        $cityId    = $request->query('city');

        try {
            $perPage = 12;

            $productsQuery = Product::active()
                ->with(['seller', 'seller.region', 'ratings', 'category'])
                ->whereHas('seller', function ($s) {
                    $s->where('is_active', true)
                      ->where('verification_status', 'verified');
                });

            // Search by product name or shop name
            if (!empty($q)) {
                $productsQuery = $productsQuery->where(function ($w) use ($q) {
                    $w->where('name', 'like', '%' . $q . '%')
                      ->orWhereHas('seller', function ($s) use ($q) {
                          $s->where('shop_name', 'like', '%' . $q . '%');
                      });
                });
            }

            // Filter by category
            if (!empty($categoryId)) {
                $productsQuery = $productsQuery->where('category_id', $categoryId);
            }

            // Filter by shop name
            if ($shopName !== '') {
                $productsQuery->whereHas('seller', function ($s) use ($shopName) {
                    $s->where('shop_name', 'like', '%' . $shopName . '%');
                });
            }

            // Filter by province (region_id)
            if (!empty($provinceId)) {
                $productsQuery->whereHas('seller', function ($s) use ($provinceId) {
                    $s->where('region_id', $provinceId);
                });
            }

            // Filter by city
            if (!empty($cityId)) {
                // Get sellers from this city
                $cityRecord = Cities::find($cityId);
                if ($cityRecord) {
                    $productsQuery->whereHas('seller', function ($s) use ($cityRecord) {
                        // Match sellers whose address contains the city name
                        $s->where('address', 'like', '%' . $cityRecord->name . '%')
                          ->where('region_id', $cityRecord->region_id);
                    });
                }
            }

            $products = $productsQuery->latest()->paginate($perPage);

            // Transform products to match frontend format
            $products->getCollection()->transform(function ($p) {
                $avg = $p->ratings->count() ? round($p->ratings->avg('rating'), 1) : 4.8;

                return [
                    'id'       => $p->id,
                    'url'      => route('products.show', $p->id),
                    'name'     => $p->name,
                    'price'    => 'Rp ' . number_format($p->price ?? 0, 0, ',', '.'),
                    'category' => optional($p->category)->name ?? 'Lainnya',
                    'location' => optional($p->seller->region)->name 
                                ?? 'Tidak diketahui',
                    'rating'   => $avg,
                    'sold'     => property_exists($p, 'sold') ? ($p->sold ?? '0') : '0',
                    'img'      => function_exists('asset') ? (
                        filter_var($p->image, FILTER_VALIDATE_URL)
                            ? $p->image
                            : (
                                Str::startsWith($p->image, 'images/')
                                    ? asset($p->image)
                                    : (
                                        (Str::startsWith($p->image, '/storage/') || Str::startsWith($p->image, 'storage/'))
                                            ? asset(ltrim($p->image, '/'))
                                            : asset('storage/' . ltrim($p->image, '/'))
                                    )
                            )
                    ) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&q=80',
                ];
            });

        } catch (QueryException $e) {
            Log::warning('ProductController: using fallback due to QueryException: ' . $e->getMessage());
            // Return empty collection on error
            $products = new LengthAwarePaginator([], 0, 12, 1, [
                'path' => url()->current(),
                'query' => $request->query(),
            ]);
        }

        // Get all provinces (regions) for dropdown
        $provinceList = Region::orderBy('name')->get();

        // Get cities for selected province
        $cityList = collect();
        if (!empty($provinceId)) {
            $cityList = Cities::where('region_id', $provinceId)
                ->orderBy('name')
                ->get();
        }

        return view('pengunjung.products', [
            'products'       => $products,
            'q'              => $q,
            'shop'           => $shopName,
            'provinceId'     => $provinceId,
            'cityId'         => $cityId,
            'provinceList'   => $provinceList,
            'cityList'       => $cityList,
            'categories'     => Category::all(),
            'activeCategory' => $categoryId,
        ]);
    }

    /**
     * AJAX: return city list for a given province.
     */
    public function cities(Request $request)
    {
        $provinceId = $request->query('province_id');
        
        if (empty($provinceId)) {
            return response()->json([]);
        }

        $cities = Cities::where('region_id', $provinceId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($cities);
    }
}