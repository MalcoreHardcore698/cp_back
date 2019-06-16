<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requisite extends Model
{
    protected $fillable = [
        'driver_id', 'reqs_id'
    ];

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
