<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * Table name is `rating_reviews` (migration created that table).
     */
    protected $table = 'rating_reviews';
    // Match migration columns: rating_reviews references product_detail_id and region_id
    protected $fillable = ['user_id', 'product_detail_id', 'rating', 'review', 'region_id', 'name', 'email', 'no_telp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
