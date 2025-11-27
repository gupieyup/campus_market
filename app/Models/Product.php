<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['seller_id', 'name', 'description', 'price', 'stock', 'image'];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
