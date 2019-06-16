<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $timestamp = false;

    public $fillable = [
        'driver_license'
    ];
}
