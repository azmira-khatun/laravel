<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'vendor_id',
        'return_invoice_no',
        'return_date',
        'product_quantity',
        'refund_amount',
        'tax_amount',
        'shipping_cost_adjustment',
        'payment_method',
        'status',
        'note',
        'net_refund', // রেকর্ড‑ভিত্তিক
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Model boot method to handle calculation before saving
     */
    protected static function booted()
    {
        static::saving(function ($return) {
            // যদি tax_amount বা shipping_cost_adjustment না দেওয়া হয়, তাহলে 0 ধরা হবে
            $tax      = $return->tax_amount               ?? 0;
            $shipping = $return->shipping_cost_adjustment ?? 0;
            $refund   = $return->refund_amount;

            // net_refund হিসাব: মূল রিফান্ড − (ট্যাক্স + শিপিং অ্যাডজাস্টমেন্ট)
            $return->net_refund = $refund - ($tax + $shipping);
        });
    }
}
