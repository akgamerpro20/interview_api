<?php

namespace App\Repositories\Api\Controllers;

use App\Models\Transaction;
use App\Repositories\Api\BaseController;
use App\Repositories\Api\Services\TransService;
use App\Repositories\Api\Validators\TransValidator;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
    protected $validator;
    protected $service;

    public function __construct(TransValidator $validator, TransService $service)
    {
        $this->validator = $validator;
        $this->service = $service;
    }
    public function all()
    {
        return "all";
    }

    public function create(Request $request)
    {
        $validator = $this->validator->create($request->all());

        if ($validator->fails()) {
            $errors = $this->getErrorObject($validator->errors());
            return $this->responseError($validator->errors()->first(), $errors, 422);
        }

        $attributes = $validator->validated();

        $transaction = $this->service->createTran($attributes);

        return $this->responseSuccess($transaction, 'Transaction Successfully!');
    }

    public function createWithJob(Request $request)
    {
        $validator = $this->validator->createWithJob($request->all());

        if ($validator->fails()) {
            $errors = $this->getErrorObject($validator->errors());
            return $this->responseError($validator->errors()->first(), $errors, 422);
        }

        $attributes = $validator->validated();

        $transaction = $this->service->createTranWithJob($attributes);

        return $this->responseSuccess($transaction, 'Transaction Successfully!');
    }

    public function approve($tranId)
    {
        $data = $this->service->approve($tranId);

        if (isset($data["error"])) {
            return $this->responseError($data["error"], null, $data["error_code"]);
        }

        return $this->responseSuccess(null, 'Transaction Successfully!');
    }
}