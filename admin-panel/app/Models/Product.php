<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Mass assignment এর জন্য fillable fields
    protected $fillable = [
        'name',
        'category_id',
        'productunit_id',
        'barcode',
        'description',
        'stock_quantity',
    ];

    /**
     * Relationship with Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relationship with ProductUnit
     */
    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class);
    }

    /**
     * Relationship: purchases
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Relationship: purchase items
     */
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

     // পণ্যটির বিভিন্ন SaleItem রেকর্ড থাকতে পারে
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Adjust stock quantity by a given amount.
     *
     * @param int    $amount The amount to adjust.
     * @param string $action 'increase' or 'decrease'
     * @throws \Exception If an invalid action or insufficient stock for decrease.
     */
    public function adjustStock(int $amount, string $action = 'increase')
    {
        if ($action === 'increase') {
            $this->stock_quantity = ($this->stock_quantity ?? 0) + $amount;
        }
        elseif ($action === 'decrease') {
            if (($this->stock_quantity ?? 0) < $amount) {
                throw new \Exception("Insufficient stock to decrease by {$amount} for product ID {$this->id}");
            }
            $this->stock_quantity = ($this->stock_quantity ?? 0) - $amount;
        }
        else {
            throw new \Exception("Invalid action '{$action}' passed to adjustStock. Use 'increase' or 'decrease'.");
        }

        $this->save();
    }
}
