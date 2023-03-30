<?php

namespace App\Repositories\Api\Validators;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AuthValidator 
{
    public function register(array $params)
    {
        return Validator::make($params, [
            'name' => 'required|string|max:255',
            'image' => 'nullable',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8'
        ]);
    }

    public function login(array $params)
    {
        return Validator::make($params, [
            'email' => 'required',
            'password' => 'required'
        ]);
    }

    public function userProfileUpdate(array $params)
    {        
        return Validator::make($params, [
            'name' => 'required|string|max:255',
            'image' => 'nullable',
            'email' => 'required|email|unique:users,email,'. auth()->user()->id,
        ]);
    }
}