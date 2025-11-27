<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a specific User who will be our main seller
        $sellerUser = User::create([
            'name' => 'Toko Perhiasan Indah',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Create a Seller profile for this user
        $seller = Seller::create([
            'user_id' => $sellerUser->id,
            'shop_name' => 'Perhiasan Indah',
            'shop_description' => 'Menjual perhiasan berkualitas tinggi dengan desain modern.',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 45',
            'province' => 'Jawa Barat',
        ]);

        // 3. Create some products for this seller
        $products = [
            ['name' => 'Kalung Wanita Kupu-Kupu', 'price' => 200000, 'stock' => 50, 'image' => 'https://via.placeholder.com/640x480.png/FFEBEE?text=Kalung+Kupu-Kupu'],
            ['name' => 'Gelang Kristal Elegan', 'price' => 150000, 'stock' => 75, 'image' => 'https://via.placeholder.com/640x480.png/FFEBEE?text=Gelang+Kristal'],
            ['name' => 'Cincin Berlian Imitasi', 'price' => 300000, 'stock' => 30, 'image' => 'https://via.placeholder.com/640x480.png/FFEBEE?text=Cincin+Berlian'],
            ['name' => 'Anting Mutiara', 'price' => 120000, 'stock' => 100, 'image' => 'https://via.placeholder.com/640x480.png/FFEBEE?text=Anting+Mutiara'],
        ];

        foreach ($products as $productData) {
            Product::create([
                'seller_id' => $seller->id,
                'name' => $productData['name'],
                'description' => 'Deskripsi untuk ' . $productData['name'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'image' => $productData['image'],
            ]);
        }

        // 4. Create some buyer users
        $buyers = User::factory(10)->create();
        $provinces = ['Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'DKI Jakarta', 'Banten', 'Yogyakarta'];

        // 5. Create ratings from buyers for the seller's products
        $sellerProducts = Product::where('seller_id', $seller->id)->get();

        foreach ($buyers as $buyer) {
            // Each buyer rates 1-3 products
            foreach ($sellerProducts->random(rand(1, 3)) as $product) {
                Rating::create([
                    'user_id' => $buyer->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5),
                    'review' => 'Produk ini sangat bagus!',
                    'province' => $provinces[array_rand($provinces)],
                ]);
            }
        }
    }
}
