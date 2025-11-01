<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $table = 'purchase_items';

    protected $fillable = [
        'purchase_id',
        'product_id',
        'unit_id',
        'quantity',
        'unit_price',
        'total_price',
        'purchased_date',
    ];

    // Cast purchased_date to a Carbon instance
    protected $casts = [
        'purchased_date' => 'datetime',
    ];

    // Relationships

    // Belongs to a purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    // Belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Belongs to a unit
    public function unit()
    {
        return $this->belongsTo(ProductUnit::class, 'unit_id');
    }
}
