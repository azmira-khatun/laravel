<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    protected $fillable = [
        'product_id',
        'product_name',
        'category_id',
        'vendor_id',
        'customer_id',
        'purchase_id',
        'sale_id',
        'transaction_type',
        'quantity',
        'stock_after',
        'purchase_price',
        'sale_price',
        'expiry_date',
        'supplier_name',
        'location_id',
        'user_id',
        'return_type',
        'unit_cost',
        'unit_price',
        'movement_date',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
