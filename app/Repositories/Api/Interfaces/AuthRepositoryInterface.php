<?php

namespace App\Repositories\Api\Interfaces;

interface AuthRepositoryInterface
{
    public function allUser();

    public function userLogin(array $params);

    public function userRegister(array $params);

    public function userProfileUpdate(array $params, object $user);

    public function userChangePassword(array $params, object $user);

    public function deleteUser();
}