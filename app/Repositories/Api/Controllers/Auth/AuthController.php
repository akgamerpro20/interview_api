<?php

namespace App\Repositories\Api\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Resources\ShopResource;
use App\Repositories\Api\BaseController;
use App\Http\Resources\UserProfileResource;
use App\Repositories\Api\Services\AuthService;
use App\Repositories\Api\Validators\AuthValidator;

class AuthController extends BaseController
{
    protected $validator;
    protected $service;

    public function __construct(AuthValidator $validator, AuthService $service)
    {
        $this->validator = $validator;
        $this->service = $service;
    }

    public function register(Request $request)
    {
        $validator = $this->validator->register($request->all());

        if ($validator->fails()) {
            $errors = $this->getErrorObject($validator->errors());
            return $this->responseError($validator->errors()->first(), $errors, 422);
        }

        $attributes = $validator->validated();
        $user = $this->service->register($attributes);

        return $this->responseSuccess($user, 'Register successfully.');
    }

    public function login(Request $request)
    {
        $validator = $this->validator->login($request->all());

        if($validator->fails()){
            $errors = $this->getErrorObject($validator->errors());
            return $this->responseError($validator->errors()->first(), $errors, 422);
        }

        $attributes = $validator->validated();

        $user = $this->service->login($attributes);

        if(!$user){
            return $this->responseError("Invalid_credentials", null, 422);
        }

        return $this->responseSuccess($user, 'Login successfully');
    }

    public function userProfile()
    {
        $user = new UserProfileResource(auth()->user());
        return $this->responseSuccess($user, "User Profile");
    }

    public function logout()
    {
        $this->service->logout();
        return $this->responseSuccess(null, 'Logout successfully');
    }

    public function userDelete()
    {
        $this->service->userDelete();
        return $this->responseSuccess(null, 'User Acc Deleted');
    }

    public function userProfileUpdate(Request $request)
    {
        $validator = $this->validator->userProfileUpdate($request->all());

        if($validator->fails()){
            $errors = $this->getErrorObject($validator->errors());
            return $this->responseError($validator->errors()->first(), $errors, 422);
        }

        $attributes = $validator->validated();

        $user = $this->service->userProfileUpdate($attributes, auth()->user());

        return $this->responseSuccess(null, 'User Profile Updated');
    }

    public function userChangePassword(Request $request)
    {
        $validator = $this->validator->userChangePassword($request->all());

        if($validator->fails()){
            $errors = $this->getErrorObject($validator->errors());
            return $this->responseError($validator->errors()->first(), $errors, 422);
        }

        $attributes = $validator->validated();

        $is_have_error = $this->service->userChangePassword($attributes, auth()->user());

        if($is_have_error){
            return $this->responseError($is_have_error, null, 422);
        }

        return $this->responseSuccess(null, 'Change Password Successfully.');
    }

    public function users()
    {
        $users = $this->service->users();
        return $this->responseSuccess($users, "Users List");
    }
}
