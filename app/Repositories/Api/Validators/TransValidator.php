<?php

namespace App\Repositories\Api\Validators;

use Illuminate\Support\Facades\Validator;

class TransValidator
{
    public function create(array $params)
    {
        return Validator::make($params, [
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required',
            'pay_date' => 'required|date_format:Y-m-d'
        ]);
    }
}