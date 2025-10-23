<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Environment extends Model
{
    use HasFactory;

    protected $table = 'environments';

    protected $fillable = [
        'application_id',
        'name',
    ];

    /**
     * Get the application that owns the environment (One-to-Many Inverse).
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    /**
     * Get the deployments for the environment (One-to-Many).
     */
    public function deployments(): HasMany
    {
        return $this->hasMany(Deployment::class, 'environment_id');
    }
}