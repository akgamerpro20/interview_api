<?php

namespace App\Repositories\Api\Interfaces;

interface AuthRepositoryInterface
{
    public function allUser();

    public function createUser(array $params);

    public function updateUser($id, array $params);

    public function deleteUser();
}