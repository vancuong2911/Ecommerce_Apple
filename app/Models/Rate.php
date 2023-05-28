<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $table = 'rates';

    protected $fillable = [
        'user_id',
        'product_id',
        'star_value',
        'comments',
        'average_rating',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
