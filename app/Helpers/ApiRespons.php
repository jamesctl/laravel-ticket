<?php

namespace App\Helpers;

class ApiRespons
{
    public static function response($data = [], $message = '', $status = 200, $code = 'OK')
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status,
            'code' => $code
        ], $status);
    }
}
