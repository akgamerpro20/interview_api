<?php

namespace App\Repositories\Api\Interfaces;

interface TranRepositoryInterface
{
    public function createTransaction(array $params);

    public function approveTransaction($tranId);
}