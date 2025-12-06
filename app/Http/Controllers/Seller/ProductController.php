<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;


class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $seller = $user ? $user->seller : null;

        if (!$seller) {
            return view('seller.produk', [
                'noSeller' => true,
                'products' => collect([]),
                'categories' => collect([]),
                'productRatings' => [],
                'productSold' => [],
            ]);
        }

        $products = Product::where('seller_id', $seller->id)->orderByDesc('created_at')->get();
        $categories = \App\Models\Category::orderBy('name')->get();

        // gather per-product stats: average rating and sold count
        $productIds = $products->pluck('id')->toArray();

        // average rating per product (join product_details -> rating_reviews)
        $ratingRows = \Illuminate\Support\Facades\DB::table('product_details')
            ->join('rating_reviews', 'product_details.id', '=', 'rating_reviews.product_detail_id')
            ->whereIn('product_details.product_id', $productIds)
            ->select('product_details.product_id', \Illuminate\Support\Facades\DB::raw('AVG(rating_reviews.rating) as avg_rating'))
            ->groupBy('product_details.product_id')
            ->get();

        $productRatings = [];
        foreach ($ratingRows as $r) {
            $productRatings[$r->product_id] = round((float) $r->avg_rating, 2);
        }

        // sold count per product (sum qty)
        $soldRows = \Illuminate\Support\Facades\DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller->id)
            ->whereIn('products.id', $productIds)
            ->select('products.id', \Illuminate\Support\Facades\DB::raw('SUM(order_items.qty) as sold'))
            ->groupBy('products.id')
            ->get();

        $productSold = [];
        foreach ($soldRows as $s) {
            $productSold[$s->id] = (int) $s->sold;
        }

        return view('seller.produk', [
            'noSeller' => false,
            'products' => $products,
            'categories' => $categories,
            'productRatings' => $productRatings,
            'productSold' => $productSold,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        $seller = $user ? $user->seller : null;

        $categories = Category::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();

        return view('seller.tambahproduk', [
            'noSeller' => $seller ? false : true,
            'categories' => $categories,
            'seller' => $seller,
            'regions' => $regions,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $seller = $user ? $user->seller : null;

        if (!$seller) {
            return redirect()->route('seller.produk')->with('error', 'Anda belum terdaftar sebagai penjual.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'region_id' => 'nullable|exists:region,id',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload (take first file if provided)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
        }

        $product = new Product();
        $product->seller_id = $seller->id;
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'] ?? 0;
        $product->category_id = $validated['category_id'];
        // Ensure product has a region_id (use seller's region if present, otherwise use submitted region_id or fallback)
        $regionId = $seller->region_id ?? ($seller->region?->id ?? null);
        if (!$regionId && isset($validated['region_id'])) {
            $regionId = $validated['region_id'];
        }
        if (!$regionId) {
            $firstRegion = Region::first();
            $regionId = $firstRegion ? $firstRegion->id : 1; // fallback to 1 if table empty
        }
        $product->region_id = $regionId;
        $product->is_active = isset($validated['is_active']) ? (bool) $validated['is_active'] : true;
        if ($imagePath) {
            // store relative public path for direct use in <img src="/storage/...">
            $product->image = '/storage/' . ltrim($imagePath, '/');
        } else {
            $product->image = '/images/products/default.png';
        }

        $product->save();

        return redirect()->route('seller.produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show edit form for a product
     */
    public function edit($id)
    {
        $user = Auth::user();
        $seller = $user ? $user->seller : null;

        if (!$seller) {
            return redirect()->route('seller.produk')->with('error', 'Anda belum terdaftar sebagai penjual.');
        }

        $product = Product::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();
        $categories = Category::orderBy('name')->get();

        return view('seller.editproduk', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update product data
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $seller = $user ? $user->seller : null;

        if (!$seller) {
            return redirect()->route('seller.produk')->with('error', 'Anda belum terdaftar sebagai penjual.');
        }

        $product = Product::where('id', $id)->where('seller_id', $seller->id)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:4096',
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'] ?? $product->stock;
        $product->category_id = $validated['category_id'];
        // Only assign description if the products table actually has the column
        if (Schema::hasColumn('products', 'description')) {
            $product->description = $validated['description'] ?? $product->description;
        }
        $product->is_active = isset($validated['is_active']) ? (bool) $validated['is_active'] : $product->is_active;

        if ($request->hasFile('image')) {
            // delete old image if we stored it in /storage
            if ($product->image && str_starts_with($product->image, '/storage/')) {
                $oldPath = ltrim(str_replace('/storage/', '', $product->image), '/');
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $imagePath = $request->file('image')->store('images/products', 'public');
            $product->image = '/storage/' . ltrim($imagePath, '/');
        }

        $product->save();

        return redirect()->route('seller.produk')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk milik seller yang sedang login
     */
    public function destroy(Request $request, $id): RedirectResponse|JsonResponse
    {
        $user = Auth::user();
        $seller = $user ? $user->seller : null;

        if (!$seller) {
            return redirect()->route('seller.produk')->with('error', 'Anda belum terdaftar sebagai penjual.');
        }

        $product = Product::where('id', $id)->where('seller_id', $seller->id)->first();
        if (!$product) {
            return redirect()->route('seller.produk')->with('error', 'Produk tidak ditemukan atau bukan milik Anda.');
        }

        // Hapus file gambar jika berada di storage
        try {
            if ($product->image && str_starts_with($product->image, '/storage/')) {
                $path = ltrim(str_replace('/storage/', '', $product->image), '/');
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete product image: ' . $e->getMessage());
        }

        $product->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus.']);
        }

        return redirect()->route('seller.produk')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Toggle active state for a product
     */
    public function toggleActive(Request $request, $id): RedirectResponse|JsonResponse
    {
        $user = Auth::user();
        $seller = $user ? $user->seller : null;

        // Log request for debugging toggle failures
        try {
            
            Log::info('ToggleActive called', [
                'user_id' => $user?->id,
                'seller_id' => $seller?->id,
                'target_product_id' => $id,
                'headers' => array_intersect_key($request->header(), array_flip(['x-csrf-token','x-requested-with','accept']))
            ]);

            if (!$seller) {
                $msg = 'Anda belum terdaftar sebagai penjual.';
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => $msg], 403);
                }
                return redirect()->route('seller.produk')->with('error', $msg);
            }

            $product = Product::where('id', $id)->where('seller_id', $seller->id)->first();
            if (!$product) {
                $msg = 'Produk tidak ditemukan atau bukan milik Anda.';
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => $msg], 404);
                }
                return redirect()->route('seller.produk')->with('error', $msg);
            }

            $product->is_active = !$product->is_active;
            $product->save();

            $msg = $product->is_active ? 'Produk diaktifkan.' : 'Produk dinonaktifkan.';
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'message' => $msg, 'is_active' => (bool) $product->is_active]);
            }

            return redirect()->route('seller.produk')->with('success', $msg);

        } catch (\Throwable $e) {
            Log::error('ToggleActive failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Server error: ' . $e->getMessage()], 500);
            }
            return redirect()->route('seller.produk')->with('error', 'Terjadi kesalahan pada server.');
        }
    }
}


