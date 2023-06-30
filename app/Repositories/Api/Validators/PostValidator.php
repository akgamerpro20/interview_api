<?php

namespace App\Repositories\Api\Validators;

use Illuminate\Support\Facades\Validator;

class PostValidator
{
    public function create(array $params): object
    {
        return Validator::make($params, [
            'text' => 'required|string|max:255',
            'video' => 'required|file|mimetypes:video/mp4',
        ]);
    }
}