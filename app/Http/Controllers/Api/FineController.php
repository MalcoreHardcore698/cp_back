<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\Driver;
use App\Models\Fine;
use App\Models\Requisite;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DriverStoreRequest;

class FineController extends Controller
{
    public function store(DriverStoreRequest $request)
    {
        $client = new Client;
        $response = $client->get(config('gos_uslugi.base_uri'), [
            'query' => [
                'v' => 2,
                'method' => 'reqs/new/driver',
                'driver_license' => $request->get('driver_license'),
                'name' => $request->get('name'),
                'access_token' => $request->get('access_token'),
            ],
        ]);

        if ($response->getStatusCode() === 302) {
            return Response::error('Could not provide Reqs', Response::ERROR_TYPE_MESSAGE, 302);
        }
        if ($response->getStatusCode() !== 200) {
            return Response::error('Not valid data, try again later');
        }

        $body = json_decode($response->getBody(), true);
        if (!isset($body['reqs_id'])) {
            return Response::error('Not valid data, try again later');
        }

        $reqsId = $body['reqs_id'];

        $driver = new Driver;
        $driver->driver_license = $request->get('driver_license');
        $driver->save();

        // create reqs for driver
        /** @var Requisite $requisite */
        $requisite = $driver->requisite()->create([
            'reqs_id' => $body['reqs_id'] ?? 0
        ]);

        $response = $client->get(config('gos_uslugi.base_uri'), [
            'query' => [
                'v' => 2,
                'method' => 'reqs/fines/check',
                'reqs_id' => $reqsId,
                'access_token' => $request->get('access_token'),
            ],
        ]);

        if ($response->getStatusCode() === 302) {
            return Response::error('Could not provide Reqs', Response::ERROR_TYPE_MESSAGE, 302);
        }
        if ($response->getStatusCode() !== 200) {
            return Response::error('Not valid data, try again later');
        }

        $body = json_decode($response->getBody(), true);
        $fineIds = $body['fines'] ?? [];
        $fines = [];
        foreach ($fineIds as $fineId) {
            $response = $client->get(config('gos_uslugi.base_uri'), [
                'query' => [
                    'v' => 2,
                    'method' => 'fine/view',
                    'fine_id' => $fineId,
                    'access_token' => $request->get('access_token'),
                ],
            ]);
            $body = json_decode($response->getBody(), true);
            if (isset($body['fine_id'])) {
                $fines[] = $body;
                $requisite->fines()->create([
                    'fine_origin_id' => $body['fine_id'],
                    'paid' => isset($body['status'])
                        ? $body['status'] !== 1
                        : false,
                ]);
            }
        }

        return response()->json($fines);
    }

    public function show(int $id)
    {
        $fine = Fine::query()->find($id);
        if ($fine === null) {
            return Response::error('Fine not found');
        }

        $fine->showed = true;
        return Response::success();
    }
}
