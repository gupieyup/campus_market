<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'region';

    protected $fillable = ['name'];

    public function sellers()
    {
        return $this->hasMany(Seller::class, 'region_id');
    }
}
