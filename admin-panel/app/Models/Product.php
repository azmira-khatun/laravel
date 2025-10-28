<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Mass assignment এর জন্য fillable fields
    protected $fillable = [
        'name',
        'category_id',
        'productunit_id',
        'barcode',
        'description',
    ];

    // যদি table নাম Laravel convention অনুসারে না হয়, তবে declare করতে হবে
    // protected $table = 'products';

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with ProductUnit
    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class);
    }
}
