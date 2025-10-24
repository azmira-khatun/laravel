<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Assumes table name is 'purchases'
     */
    protected $table = 'purchases';

    /**
     * The attributes that are mass assignable.
     * These match the columns in your 'purchases' migration.
     */
    protected $fillable = [
        'vendor_id',
        'purchase_date',
        'total_amount',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'purchase_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    // --- Relationships ---

    /**
     * Get the vendor that supplied the goods for the purchase.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Get the purchase items associated with this purchase.
     * This is crucial for saving items in the store() method.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }
}