<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    protected $fillable = [
        'requisite_id', 'fine_origin_id', 'paid'
    ];

    public function requisite(): BelongsTo
    {
        return $this->belongsTo(Requisite::class);
    }

    public function sendPushNotification(string $text): void
    {
        /** @var Requisite|null $requisite */
        $requisite = $this->requisite;
        if ($requisite === null) {
            return;
        }
        /** @var Driver $driver */
        $driver = $requisite->driver;
        if ($driver === null) {
            return;
        }
        /** @var PushToken $pushToken */
        foreach ($driver->pushTokens as $pushToken) {
            $pushToken->sendNotification($text);
        }
    }
}
