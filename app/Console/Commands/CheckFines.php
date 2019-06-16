<?php

namespace App\Console\Commands;

use App\Models\Fine;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CheckFines extends Command
{
    public const TEXT_DEFAULT = '';
    public const TEXT_DATE_EXPIRED = '';
    public const TEXT_NEED_TO_SHOW = '';
    public const TEXT_DAY_19 = '';

    public const EVERY_ONE_DAY = 'every_one_day';
    public const EVERY_THREE_DAY = 'every_three_day';


    protected $signature = 'check:fines';
    protected $description = 'Check fine deadline';

    /** @var Client $client */
    private $client;
    /** @var Carbon $now */
    private $now;
    private $mode = self::EVERY_ONE_DAY;

    public function __construct()
    {
        $this->client = new Client;
        $this->now = Carbon::now();
    }

    public function handle(): void
    {
        if ($this->option(self::EVERY_THREE_DAY) !== null) {
            $this->mode = self::EVERY_THREE_DAY;
        }

        /** @var Collection $fines */
        $fines = Fine::query()->get();
        /** @var Fine $fine */
        foreach ($fines as $fine) {
            if ($fine->paid) {
                continue;
            }
            $date = $this->fineNotification($fine->id);
            if ($date === null) {
                continue;
            }
            $date = Carbon::parse($date);
            $date19 = $date->ceilDay(19);
            if ($date19->isCurrentDay()) {
                $fine->sendPushNotification(self::TEXT_DAY_19);
            }

            switch ($this->mode) {
                case self::EVERY_ONE_DAY:
                    if (!$fine->showed) {
                        $fine->sendPushNotification(self::TEXT_NEED_TO_SHOW);
                    }
                    if ($this->now->greaterThan($date->addDay(20))) {
                        $fine->sendPushNotification(self::TEXT_DATE_EXPIRED);
                    }
                    return;

                case self::EVERY_THREE_DAY:
                    if (!$this->now->greaterThan($date->addDay(20))) {
                        $fine->sendPushNotification(self::TEXT_DEFAULT);
                    }
                    return;
            }
        }
    }

    protected function fineNotification(int $fineId): ?string
    {
        $response = $this->client->get(config('gos_uslugi.base_uri'), [
            'query' => [
                'v' => 2,
                'method' => 'fine/view',
                'fine_id' => $fineId,
                'access_token' => $this->option('token'),
            ],
        ]);
        $body = json_decode($response->getBody(), true);
        return $body['date'] ?? null;
    }
}
