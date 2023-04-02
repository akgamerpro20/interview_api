<?php

namespace App\Repositories\Api\Services;

use App\Repositories\Api\Eloquent\AuthRepository;

class AuthService
{
    protected $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function users()
    {
        return $this->repository->allUser();
    }

    public function login(array $params)
    {
        return $this->repository->login($params);
    }

    public function register(array $params)
    {
        return $this->repository->register($params);
    }

    public function userProfileUpdate(array $params, object $user)
    {
        return $this->repository->userProfileUpdate($params, $user);
    }

    public function userChangePassword(array $params, object $user)
    {
        return $this->repository->userChangePassword($params, $user);
    }

    public function userDelete()
    {
        return $this->repository->deleteUser();
    }

    public function logout()
    {
        return auth()->user()->currentAccessToken()->delete();
    }
}