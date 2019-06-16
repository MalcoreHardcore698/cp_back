<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DriverStoreRequest;

class DriverController extends Controller
{
    public function store(DriverStoreRequest $request)
    {
        $client = new Client;
        $response = $client->get(config('gos_uslugi.base_uri'), [
            'query' => [
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
    }
}
