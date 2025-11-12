<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vendor_id',
        'user_id',
        'product_id',
        'subtotal_amount',
        'productunit_id',
        'discount_amount',
        'tax_amount',
        'shipping_cost',
        'total_cost',
        'paid_amount',
        'due_amount',
        'payment_method_id',
        'payment_status',
        'purchase_date',
        'receive_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'subtotal_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount'       => 'decimal:2',
        'shipping_cost'    => 'decimal:2',
        'total_cost'       => 'decimal:2',
        'paid_amount'      => 'decimal:2',
        'due_amount'       => 'decimal:2',
        'purchase_date'    => 'datetime',
        'receive_date'     => 'date',
    ];

    /**
     * Relationships
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class, 'productunit_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
