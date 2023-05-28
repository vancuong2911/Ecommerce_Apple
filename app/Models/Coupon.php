<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'details',
        'percentage',
        'code'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function couponProduct()
    {
        return $this->hasOne(CouponProduct::class, 'coupon_id');
    }
}
