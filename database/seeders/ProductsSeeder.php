<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Baju Batik',
                'price' => 150000,
                'stock' => 10,
                'image' => 'images/products/batik-pink.jpeg',
                'seller_id' => 1,
                'category_id' => 1,
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'MacBook Pro M4 14-inch',
                'price' => 27500000,
                'stock' => 5,
                'image' => 'images/products/laptop-pink.jpg',
                'seller_id' => 1,
                'category_id' => 2,
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Gelang Kulit',
                'price' => 180000,
                'stock' => 50,
                'image' => 'images/products/gelang-pink.jpg',
                'seller_id' => 2,
                'category_id' => 3,
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Kertas Binder Loose Leaf',
                'price' => 10000,
                'stock' => 100,
                'image' => 'images/products/kertas-pink.jpg',
                'seller_id' => 3,
                'category_id' => 4,
                'is_active' => true,
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Vitamin C',
                'price' => 85000,
                'stock' => 30,
                'image' => 'images/products/obat-pink.jpg',
                'seller_id' => 1,
                'category_id' => 5,
                'is_active' => true,
                'created_at' => now(),
            ],
        ]);
    }
}