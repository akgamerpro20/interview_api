<?php

namespace App\Repositories\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public function responseSuccess($params, $result, $message = null)
    {
        $response = [
            'code'    => 200,
            'status'  => 'success',
            'message' => $message
        ];

        if (isset($params['page']) && isset($params['row_count'])) {
            $inputs['page']  = (int) $params['page'];
            $inputs['total_page']  = (int) $result['total_page'] ?? null;
            $inputs['row_count'] = (int) $params['row_count'];
            $inputs['total_records_count'] = (int) $result['total'];
            $response['pagination'] = $inputs;
        }

        //for index
        if(isset($result['data'])){
            $response['data'] = $result['data'];
        }else{
            //for created
            if($result && $params){
                $created['id'] = $result;                       
                $response['data'] = array_merge($params, $created);
            }else{
                 $response['data'] = $result;
            }
        }
        
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