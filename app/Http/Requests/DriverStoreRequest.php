<?php

namespace App\Http\Requests;

use App\Helpers\JsonFormRequest;

class DriverStoreRequest extends JsonFormRequest
{
    public function rules(): array
    {
        return [
            'driver_license' => 'required|string|max:255',
            'name' => 'string|nullable|max:255',
        ];
    }
}
