<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'name',
    ];

    // Application Has Many Environments
    public function environments(): HasMany
    {
        return $this->hasMany(Environment::class, 'application_id');
    }

    // Application Has Many Deployments (Through Environment)
    public function deployments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Deployment::class,    // Target Model
            Environment::class,   // Intermediate Model
            'application_id',     // Foreign key on the environments table
            'environment_id',     // Foreign key on the deployments table
            'id',                 // Local key on the applications table
            'id'                  // Local key on the environments table
        );
    }
}