<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mechanie extends Model
{
    public function carOwner()
    {
        return $this->hasOneThrough(Owner::class, Car::class);
    }
}
