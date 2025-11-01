<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_quantity',
        'subtotal_amount',
        'tax_amount',
        'shipping_cost_adjustment',
        'refund_amount',
        'payment_method',
        'status',
        'note',
        'return_date',
    ];

    protected $casts = [
        'return_date' => 'date',
    ];

    // Relationship to Purchase
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
