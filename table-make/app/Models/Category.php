<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    // HasOneThrough: Category -> Product -> Order
    public function order()
    {
        // hasOneThrough(Final, Through, throughForeignKey, finalForeignKey, localKey, throughLocalKey)
        return $this->hasOneThrough(
            Order::class,     
            Product::class,   // through model
            'category_id',    // products.category_id (throughForeignKey)
            'product_id',     // orders.product_id (finalForeignKey)
            'id',             // categories.id (localKey)
            'id'              // products.id (throughLocalKey)
        );
    }
}
