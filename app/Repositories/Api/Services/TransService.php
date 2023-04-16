<?php

namespace App\Repositories\Api\Services;

use App\Repositories\Api\Eloquent\TranRepository;

class TransService
{
    protected $repository;

    public function __construct(TranRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createTran(array $params)
    {
        return $this->repository->createTransaction($params);
    }

    public function createTranWithJob(array $params)
    {
        return $this->repository->createTransactionWithJob($params);
    }

    public function approve($tranId)
    {
        return $this->repository->approveTransaction($tranId);
    }
}