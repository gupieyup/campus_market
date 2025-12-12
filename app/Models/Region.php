<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'region';
    
    protected $fillable = ['name', 'code'];

    public function sellers()
    {
        return $this->hasMany(Seller::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function cities()
    {
        return $this->hasMany(Cities::class);
    }
}