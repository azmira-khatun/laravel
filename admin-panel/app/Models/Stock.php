<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    //fillable ফিল্ড নির্ধারণ
    protected $fillable = [
        'product_id',
        'quantity',
        'user_id',
    ];

    // relation: product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // relation: user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
