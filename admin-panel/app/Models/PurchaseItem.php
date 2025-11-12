<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $table   = 'purchase_items';
    public    $timestamps = false;  // যদি শুধু created_at থাকে, updated_at না থাকে

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'unit_price',
        'line_discount',
        'line_total',
    ];

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
