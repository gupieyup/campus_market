<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create seller profiles for the seeded users with role 'Penjual'
        DB::table('sellers')->insert([
            [
                'user_id' => 2,
                'shop_name' => 'Toko Gladys',
                'shop_description' => 'Pilihan batik modern dan tradisional.',
                'phone' => '081200000002',
                'address' => 'Jl. Batik No.2',
                'region_id' => 1,
                'created_at' => now(),
            ],
            [
                'user_id' => 3,
                'shop_name' => 'Gelang Kaila',
                'shop_description' => 'Perhiasan dan aksesoris handmade.',
                'phone' => '081200000003',
                'address' => 'Jl. Gelang No.3',
                'region_id' => 2,
                'created_at' => now(),
            ],
            [
                'user_id' => 4,
                'shop_name' => 'Stationery Lulu',
                'shop_description' => 'Alat tulis dan kebutuhan kantor.',
                'phone' => '081200000004',
                'address' => 'Jl. Kertas No.4',
                'region_id' => 3,
                'created_at' => now(),
            ],
        ]);
    }
}
