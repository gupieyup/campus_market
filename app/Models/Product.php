<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['seller_id', 'name', 'description', 'price', 'stock', 'image', 'category_id', 'is_active'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Ratings are stored on product details table (rating_reviews.product_detail_id).
     * Use hasManyThrough through ProductDetail so $product->ratings works as expected.
     */
    public function ratings()
    {
        return $this->hasManyThrough(Rating::class, ProductDetail::class, 'product_id', 'product_detail_id', 'id', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }
}