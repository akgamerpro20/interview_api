<?php

namespace App\Repositories\Api\Validators;

use Illuminate\Support\Facades\Validator;

class NotiValidator 
{
    public function create(array $params)
    {
        return Validator::make($params, [
            'sent_to' => 'required|integer',
            'noti_type' => 'required|integer',
            'title' => 'required|string|max:255',
            'message' => 'required',
            'detail' => 'nullable',
            'schedule_date' => 'nullable',
            'image' => 'nullable'
        ]);
    }
}