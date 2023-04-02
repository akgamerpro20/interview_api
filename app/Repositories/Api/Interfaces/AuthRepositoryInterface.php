<?php

namespace App\Repositories\Api\Interfaces;

interface AuthRepositoryInterface
{
    public function allUser();

    public function login(array $params);

    public function register(array $params);

    public function userProfileUpdate(array $params, object $user);

    public function userChangePassword(array $params, object $user);

    public function deleteUser();
}