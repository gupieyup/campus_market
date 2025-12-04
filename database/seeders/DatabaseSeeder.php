<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            CategoriesSeeder::class,
            RegionsSeeder::class,
            SellersSeeder::class,
            ProductsSeeder::class,
            ProductDetailsSeeder::class,
            // CartsSeeder::class,
            // CartItemsSeeder::class,
            OrdersSeeder::class,
            OrderItemsSeeder::class,
            RatingReviewSeeder::class,
        ]);
    }
}
