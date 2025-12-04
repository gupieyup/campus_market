<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = ['user_id', 'shop_name', 'shop_description', 'shop_image', 'phone', 'address', 'region_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
