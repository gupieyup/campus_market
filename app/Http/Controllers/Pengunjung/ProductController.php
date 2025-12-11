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
use App\Models\Seller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Determine the column used for city/regency in the region table.
     */
    private function getCityColumn(): ?string
    {
        $candidates = ['city', 'kabupaten', 'kota', 'city_name', 'regency'];
        foreach ($candidates as $c) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('region', $c)) {
                return $c;
            }
        }
        return null;
    }

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
                    // e.g. "images/products/xyz.jpg" in public dir
                    $imageUrl = asset($img);
                } elseif (Str::startsWith($img, '/storage/') || Str::startsWith($img, 'storage/')) {
                    // already a storage-backed path from uploader
                    $imageUrl = asset(ltrim($img, '/'));
                } else {
                    // fallback: assume file stored under storage/public
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
        $province  = trim($request->query('province', ''));
        $city      = trim($request->query('city', ''));
        try {
            $perPage = 12;

            $productsQuery = Product::active()
                ->with(['seller', 'seller.region', 'ratings', 'category'])
                ->whereHas('seller', function ($s) {
                    $s->where('is_active', true)
                      ->where('verification_status', 'verified');
                });

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

            if ($shopName !== '') {
                $productsQuery->whereHas('seller', function ($s) use ($shopName) {
                    $s->where('shop_name', 'like', '%' . $shopName . '%');
                });
            }

            if ($province !== '') {
                if (Schema::hasColumn('region', 'name')) {
                    $productsQuery->whereHas('seller.region', function ($r) use ($province) {
                        $r->where('name', 'like', '%' . $province . '%');
                    });
                }
            }

            if ($city !== '') {
                // No city column in region; match seller address text
                $productsQuery->whereHas('seller', function ($s) use ($city) {
                    $s->where('address', 'like', '%' . $city . '%');
                });
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
                    'category' => optional($p->category)->name ?? 'Lainnya',
                    'location' => optional($p->seller->region)->name 
                                ?? optional($p->seller->region)->region_name 
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
            Log::warning('HomeController: using fallback demo due to QueryException: ' . $e->getMessage());
            // fallback demo
            // $items = [
            //     [
            //         'id'       => 1,
            //         'url'      => '#',
            //         'name'     => 'Laptop Gaming ASUS ROG Bekas Mulus',
            //         'price'    => 'Rp 8.500.000',
            //         'location' => 'Jakarta Selatan',
            //         'rating'   => '4.8',
            //         'sold'     => '12',
            //         'img'      => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=500&q=80',
            //     ],
            //     [
            //         'id'       => 2,
            //         'url'      => '#',
            //         'name'     => 'Kemeja Flannel Uniqlo Size L',
            //         'price'    => 'Rp 150.000',
            //         'location' => 'Bandung',
            //         'rating'   => '4.9',
            //         'sold'     => '5',
            //         'img'      => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&q=80',
            //     ],
            // ];

            // $perPage = 12;
            // $page = max(1, (int) $request->query('page', 1));

            // $products = new LengthAwarePaginator(
            //     array_slice($items, ($page - 1) * $perPage, $perPage),
            //     count($items),
            //     $perPage,
            //     $page,
            //     [
            //         'path'  => url()->current(),
            //         'query' => $request->query(),
            //     ]
            // );
        }

        // Dropdown sources from Region (resilient to column differences)
        $provinceList = collect();
        if (Schema::hasColumn('region', 'name')) {
            $provinceList = Region::select('name as province')
                ->whereNotNull('name')
                ->distinct()->orderBy('province')->pluck('province');
        }
        $cityList = collect();
        if ($province !== '' && Schema::hasColumn('region', 'name')) {
            $region = Region::where('name', $province)->first();
            if ($region) {
                $cityList = Seller::where('region_id', $region->id)
                    ->where('is_active', true)
                    ->where('verification_status', 'verified')
                    ->whereNotNull('address')
                    ->select('address as city')
                    ->distinct()
                    ->orderBy('city')
                    ->pluck('city');
            }
        }

        return view('pengunjung.products', [
            'products'       => $products,
            'q'              => $q,
            'shop'           => $shopName,
            'province'       => $province,
            'city'           => $city,
            'provinceList'   => $provinceList,
            'cityList'       => $cityList,
            'categories'     => Category::all(),
            'activeCategory' => $categoryId,
        ]);
    }

    /**
     * AJAX: return city/regency list for a given province.
     */
    public function cities(Request $request)
    {
        $province = trim($request->query('province', ''));
        if (!Schema::hasColumn('region', 'name')) {
            return response()->json([]);
        }
        $region = Region::where('name', $province)->first();
        if (!$region) {
            return response()->json([]);
        }
        $cities = Seller::where('region_id', $region->id)
            ->where('is_active', true)
            ->where('verification_status', 'verified')
            ->whereNotNull('address')
            ->select('address as city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');
        return response()->json($cities);
    }
}