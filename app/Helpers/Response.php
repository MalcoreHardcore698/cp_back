<?php

namespace App\Helpers;

class Response
{
    public const ERROR_TYPE_MESSAGE = 'message';
    public const ERROR_TYPE_VALIDATION = 'message';

    public static function success($success = true, $httpCode = 200)
    {
        return self::make(['success' => $success], $httpCode);
    }

    public static function error($error = [], $errorType = self::ERROR_TYPE_MESSAGE, $httpCode = 400)
    {
        return self::make([
            'success' => false,
            'error' => $error,
            'errorType' => $errorType,
        ], $httpCode);
    }

    public static function make($data = [], $httpCode = 200)
    {
        return response()->json($data, $httpCode);
    }
}