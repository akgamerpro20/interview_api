<?php

namespace App\Repositories\Api\Eloquent;

use App\Models\User;
use App\Http\Resources\ShopResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Api\BaseRepository;
use App\Repositories\Api\Interfaces\AuthRepositoryInterface;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function allUser()
    {
        $users = $this->connection()->paginate(2);
        return $users;
    }

    public function login(array $params)
    {
        if (Auth::attempt($params)) {
            $user = Auth::user();
            $token = $user->createToken($user->email)->plainTextToken;
            $data = [
                'id' => $user->id,
                'image' => image_path($user->image),
                'email' => $user->email,
                'password' => $user->password,
                'token' => $token,
                'shops' => ShopResource::collection($user->shops),
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
        $user = $this->create($params);
        $user['token'] = $user->createToken($user)->plainTextToken;

        return $user;
    }

    public function userProfileUpdate(array $params, object $user)
    {
        if (isset($params['image'])) {
            deleteImage($user->image);
            $params['image'] = uploadImageFile($params['image'], 'user-profile/');
        } else {
            $params['image'] = $user->image;
        }

        return $this->update($user->id, [
            'name' => $params['name'],
            'email' => $params['email'],
            'image' => $params['image']
        ]);
    }

    public function userChangePassword(array $params, object $user)
    {
        $error = null;

        if (!Hash::check($params['old_password'], auth()->user()->password)) {
            return $error = "Your old password is wrong.";
        }

        if ($params['new_password'] != $params['confirm_password']) {
            return $error = "Your new password is not the same.";
        }

        $updateUser = $this->update($user->id, [
            'password' => bcrypt($params['new_password'])
        ]);

        if (!$updateUser) {
            return $error = "Failed Password Changed.";
        }

        return $error;
    }

    public function deleteUser()
    {
        $id = auth()->user()->id;

        if ($id) {
            deleteImage(auth()->user()->image);
        }

        return $this->delete($id);
    }
}