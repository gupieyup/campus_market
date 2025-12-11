<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('region')->insert([
            ['id' => 1, 'name' => 'Jawa Timur'],
            ['id' => 2, 'name' => 'Jawa Barat'],
            ['id' => 3, 'name' => 'Jawa Tengah'],
            ['id'=> 4, 'name' => 'DKI Jakarta'],
            ['id'=> 5, 'name' => 'Bali'],
            ['id'=> 6, 'name' => 'DI Yogyakarta'],
            ['id'=> 7, 'name' => 'Sumatra Utara'],
            ['id'=> 8, 'name' => 'Sumatra Selatan'],
            ['id'=> 9, 'name' => 'Sumatra Barat'],
            ['id'=> 10, 'name' => 'Sulawesi Selatan'],
            ['id'=> 11, 'name' => 'Sulawesi Utara'],
            ['id'=> 12, 'name' => 'Sulawesi Tengah'],
            ['id'=> 13, 'name' => 'Kalimantan Timur'],
            ['id'=> 14, 'name' => 'Kalimantan Barat'],
            ['id'=> 15, 'name' => 'Kalimantan Selatan'],
            ['id'=> 16, 'name' => 'Papua'],
            ['id'=> 17, 'name' => 'Banten'],
            ['id'=> 18, 'name' => 'Nusa Tenggara Barat'],
            ['id'=> 19, 'name' => 'Nusa Tenggara Timur'],
            ['id'=> 20, 'name' => 'Aceh'],
            ['id'=> 21, 'name' => 'Bengkulu'],
            ['id'=> 22, 'name' => 'Jambi'],
            ['id'=> 23, 'name' => 'Riau'],
            ['id'=> 24, 'name' => 'Lampung'],
            ['id'=> 25, 'name' => 'Maluku'],
            ['id'=> 26, 'name' => 'Maluku Utara'],
            ['id'=> 27, 'name' => 'Gorontalo'],
            ['id'=> 28, 'name' => 'Bangka Belitung'],
            ['id'=> 29, 'name' => 'Kepulauan Riau'],
            ['id'=> 30, 'name' => 'Papua Barat'],
            ['id'=> 31, 'name' => 'Sulawesi Barat'],
            ['id'=> 32, 'name' => 'Sulawesi Tenggara'],
            ['id'=> 33, 'name' => 'Kalimantan Tengah'],
            ['id'=> 34, 'name' => 'Kalimantan Utara'],
        ]);
    }
}
