<?php

namespace App\Repositories\Api\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Api\BaseController;

class PhoneController extends BaseController
{
    public function checkPhNo(Request $request)
    {
        if (!validate_number($request->phone_no)) {
            return $this->responseError($request->phone_no, 'Invalid Phone No.', 401);
        }

        return $this->responseSuccess($request->phone_no, 'Correct Phone No.');
    }
}