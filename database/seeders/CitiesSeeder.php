<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            [
                'id' => 1,
                'name' => 'Kota Surabaya',
                'region_id' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Kota Malang',
                'region_id' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Kota Kediri',
                'region_id' => 1,
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Kota Bandung',
                'region_id' => 2,
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Kota Bekasi',
                'region_id' => 2,
                'created_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Kota Depok',
                'region_id' => 2,
                'created_at' => now(),  
            ],
            [
                'id' => 7,
                'name' => 'Kota Semarang',
                'region_id' => 3,
                'created_at' => now(),
            ],
            [
                'id' => 8,
                'name' => 'Kota Solo',
                'region_id' => 3,
                'created_at' => now(),
            ],
            [
                'id' => 9,
                'name' => 'Kabupaten Magelang',
                'region_id' => 3,
                'created_at' => now(),
            ],
            [
                'id' => 10,
                'name' => 'Kota Jakarta Selatan',
                'region_id' => 4,
                'created_at' => now(),
            ],
            [
                'id' => 11,
                'name' => 'Kota Jakarta Barat',
                'region_id' => 4,
                'created_at' => now(),
            ],
            [
                'id' => 12,
                'name' => 'Kota Jakarta Pusat',
                'region_id' => 4,
                'created_at' => now(),
            ],
            [
                'id' => 13,
                'name' => 'Kota Jakarta Timur',
                'region_id' => 4,
                'created_at' => now(),
            ],
            [
                'id' => 14,
                'name' => 'Kota Jakarta Utara',
                'region_id' => 4,
                'created_at' => now(),
            ],
            [
                'id' => 15,
                'name' => 'Kota Denpasar',
                'region_id' => 5,
                'created_at' => now(),
            ],
            [
                'id' => 16,
                'name' => 'Kota Yogyakarta',
                'region_id' => 6,
                'created_at' => now(),
            ],
            [
                'id' => 17,
                'name' => 'Kabupaten Sleman',
                'region_id' => 6,
                'created_at' => now(),
            ],
            [
                'id' => 18,
                'name' => 'Kabupaten Bantul',
                'region_id' => 6,
                'created_at' => now(),
            ],
            [
                'id' => 19,
                'name' => 'Kota Medan',
                'region_id' => 7,
                'created_at' => now(),
            ],
        ]); 
    }
}
