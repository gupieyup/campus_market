<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating_reviews';
    
    protected $fillable = [
        'user_id', 
        'product_detail_id', 
        'rating', 
        'review', 
        'region_id', 
        'name', 
        'email', 
        'no_telp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Perbaikan: gunakan foreign key yang sesuai dengan tabel
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_detail_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}