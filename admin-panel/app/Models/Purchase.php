<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'invoice_no',
        'purchase_date',
        'product_quantity',
        'subtotal_amount',
        'discount_amount',
        'product_price',
        'paid_amount',
        'due_amount',
        'payment_status',
        'payment_method',
        'receive_date',
        'status',
        'note',
        'tax_amount',
        'shipping_cost',
        'total_cost',
    ];

    // Relation with Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    // Purchase model
    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }

}
