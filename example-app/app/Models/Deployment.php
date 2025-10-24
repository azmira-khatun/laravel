<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deployment extends Model
{
    use HasFactory;

    protected $table = 'deployments';

    protected $fillable = [
        'environment_id',
        'commit_hash',
    ];

    /**
     * Get the environment that the deployment belongs to (One-to-Many Inverse).
     */
    public function environment(): BelongsTo
    {
        return $this->belongsTo(Environment::class, 'environment_id');
    }
}