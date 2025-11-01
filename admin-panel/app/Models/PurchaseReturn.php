<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'total_quantity',
        'subtotal_amount',
        'tax_amount',
        'shipping_cost',
        'return_quantity',
        'refund_amount',
        'net_refund',
        'payment_method',
        'status',
        'note'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }


}