<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    public $fillable = [
        'driver_license'
    ];

    public function requisite(): HasMany
    {
        return $this->hasMany(Requisite::class, 'driver_id');
    }

    public function pushTokens(): HasMany
    {
        return $this->hasMany(PushToken::class);
    }
}
