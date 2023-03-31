<?php

namespace App\Repositories\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function responseSuccess($result, $message = null)
    {
        $response = [
            'code'    => 200,
            'status'  => 'success',
            'message' => $message
        ];

        $response['data'] = $result;
        
        return response()->json($response, 200);
     
    }

    public function responseError($error, $errorMessages = [], $code = 422)
    {
        $response = [
            'code'    => $code,
            'status' => 'failed',
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function getErrorObject($errors)
    {
        return collect($errors)
                ->map(fn($error) => $error[0]);
    }
}