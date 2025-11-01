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
        'stock_quantity',         // এখানে নতুন ফিল্ড যুক্ত
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
     * Relationship: purchase items (optional)
     */
    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * স্টক পরিমাণ সামঞ্জস্য করার ফাংশন
     *
     * @param int    $amount   পরিবর্তনের পরিমাণ
     * @param string $action   'increase' বা 'decrease'
     * @return void
     */
    public function adjustStock(int $amount, string $action = 'increase')
    {
        if ($action === 'increase') {
            $this->stock_quantity = ($this->stock_quantity ?? 0) + $amount;
        } elseif ($action === 'decrease') {
            $this->stock_quantity = max(0, ($this->stock_quantity ?? 0) - $amount);
        }

        $this->save();
    }
}
