<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }
}