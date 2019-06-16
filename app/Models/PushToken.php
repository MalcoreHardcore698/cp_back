<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushToken extends Model
{
    public const PLATFORM_ANDROID = 'android';
    public const PLATFORM_IOS = 'ios';

    protected $fillable = [
        'token', 'platform', 'driver_id',
    ];

    public function sendNotification(string $text)
    {
        // logic for sending
    }
}
