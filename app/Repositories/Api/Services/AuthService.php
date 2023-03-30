<?php

namespace App\Repositories\Api\Services;

use App\Models\User;
use App\Http\Resources\ShopResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CategoryResource;

class AuthService
{
    public function login(array $params)
    {
        if (Auth::attempt($params)) {
            $user = Auth::user();
            $token = $user->createToken($user->email)->plainTextToken;
            $data = [
                'id'       => $user->id,
                'image'    => image_path($user->image),
                'email'    => $user->email,
                'password' => $user->password,
                'token'    => $token,
                'shops'     => ShopResource::collection($user->shops),
            ];
            return $data;
        }

        return null;
    }

    public function register(array $params)
    {
        if ($params['image']) {
            $params['image'] = uploadImageFile($params['image'], 'user-profile/');
        }

        $params['password'] = bcrypt($params['password']);
        $user = User::create($params);
        $user['token'] = $user->createToken($user)->plainTextToken;

        return $user;
    }

    public function userProfileUpdate(array $params, object $user)
    {
        if(isset($params['image']))
        {
            deleteImage($user->image);
            $params['image'] = uploadImageFile($params['image'], 'user-profile/');
        }else{
            $params['image'] = $user->image;
        }

        return $user->update([
            'name' => $params['name'],
            'email' => $params['email'],
            'image' => $params['image']
        ]);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
    }

    public function userDelete()
    {
        deleteImage(auth()->user()->image);
        auth()->user()->delete();
    }

    public function userChangePassword(array $params, object $user)
    {
        $error = null;

        if (!Hash::check($params['old_password'], auth()->user()->password)) {
            $error = "Your old password is wrong.";
            return $error;
        }

        if ($params['new_password'] != $params['confirm_password'])
        {
            $error = "Your new password is not the same.";
            return $error;
        }

        $user->update([
            'password' => bcrypt($params['new_password'])
        ]);

        return $error;
    }
}