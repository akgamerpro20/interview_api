<?php

namespace App\Repositories\Api\Eloquent;

use App\Models\Transaction;
use App\Repositories\Api\BaseRepository;
use App\Repositories\Api\Interfaces\TranRepositoryInterface;

class TranRepository extends BaseRepository implements TranRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    public function createTransaction(array $params)
    {
        $transaction = $this->create($params);
        return $transaction;
    }

    public function approveTransaction($tranId)
    {
        $data = null;
        $data["error_code"] = 422; //default error code

        $transaction = Transaction::where('id', $tranId)->where('status', 0)->first();

        if (!$transaction) {
            $data["error"] = "Not Found Trans";
            return $data;
        }

        $this->update($transaction->id, [
            "status" => 1
        ]);

        return $data;
    }
}