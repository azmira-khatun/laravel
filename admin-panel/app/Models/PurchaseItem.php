<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'purchase_items';

    /**
     * The attributes that are mass assignable.
     * These fields are accepted from the purchase creation form.
     */
    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'unit_price',
        'sale_price',
        'manufacture_date',
        'expiry_date',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'manufacture_date' => 'date', // Casts the column to a Carbon date object
        'expiry_date' => 'date',
    ];

    // --- Relationships ---

    /**
     * Get the Purchase that owns the PurchaseItem.
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the specific Product that was purchased.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}