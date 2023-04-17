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
            'pay_date' => 'required|date_format:Y-m-d',
            'schedule_date' => 'required|date_format:Y-m-d H:i:s'
        ]);
    }

    public function createWithJob(array $params)
    {
        return Validator::make($params, [
            'tran_count' => 'required|integer',
            'user_id' => 'required|integer|exists:users,id',
            'amount' => 'required',
            'pay_date' => 'required|date_format:Y-m-d'
        ]);
    }
}