<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'user_id', 
        'shop_name', 
        'shop_description', 
        'shop_image', 
        'phone', 
        'address', 
        'is_active',
        'region_id',
        'verification_status',
        'rejection_reason',  // Tambahan untuk alasan penolakan
        'nik',               // Tambahan untuk NIK/KTP
        'ktp_image',         // Tambahan untuk foto KTP
        'verified_at',       // Tambahan untuk tanggal verifikasi
        'verified_by'        // Tambahan untuk ID admin yang verifikasi
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'verified_at' => 'datetime'
    ];

    /**
     * Relasi ke User (pemilik toko)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /**
     * Relasi ke Region
     */
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /**
     * Relasi ke User yang melakukan verifikasi (admin)
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope untuk filter berdasarkan status verifikasi
     */
    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('verification_status', 'rejected');
    }

    /**
     * Accessor untuk status badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => '<span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Pending</span>',
            'verified' => '<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Verified</span>',
            'rejected' => '<span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Rejected</span>',
        ];

        return $badges[$this->verification_status] ?? '';
    }
}