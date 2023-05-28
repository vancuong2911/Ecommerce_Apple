<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'name', 'price', 'description', 'image'
    ];
    public $timestamps = true;
    public function couponProducts()
    {
        return $this->hasOne(CouponProduct::class);
    }
}
