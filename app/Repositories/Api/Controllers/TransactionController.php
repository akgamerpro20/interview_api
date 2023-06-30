<?php

namespace App\Repositories\Api\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseController;
use App\Repositories\Api\Services\TransService;
use App\Repositories\Api\Validators\TransValidator;

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

    public function EncryptData()
    {
        $result = bin2hex(openssl_encrypt("My name is naywin.", "AES-128-CBC", "CGsSGeYvYQxF2Aw4", OPENSSL_RAW_DATA, "bUnFCdTZkReC3wL5"));
        return response()->json($result);
    }

    public function DecryptData()
    {
        $data = "d413b88cfc7593942df7c623e31c8be66b99c0fb5b01edc6db774803304b7a92";
        $result = openssl_decrypt(hex2bin($data), "AES-128-CBC", "CGsSGeYvYQxF2Aw4", OPENSSL_RAW_DATA, "bUnFCdTZkReC3wL5");
        return response()->json($result);
    }

    public function checkMyanmar()
    {
        if ($this->isMyanmar() == "true") {
            return "Myanmar";
        } else if ($this->isMyanmar() == "false") {
            return "International";
        }
    }

    protected function isMyanmar()
    {

        // return $_SERVER['REMOTE_ADDR'];
        // 65.18.123.214
        // $ip = "65.18.123.214";
        $ip = $_SERVER['REMOTE_ADDR'];

        $ranges = [
            "34.98.230.0/23",
            "34.98.246.0/23",
            "34.103.6.0/23",
            "37.111.0.0/17",
            "42.156.32.0/22",
            "43.224.40.0/22",
            "43.224.84.0/22",
            "43.227.12.0/22",
            "43.242.134.0/23",
            "43.245.44.0/22",
            "45.10.234.176/28",
            "45.41.96.0/19",
            "45.112.176.0/22",
            "45.120.84.0/22",
            "45.201.232.0/21",
            "45.250.200.0/22",
            "45.250.240.0/22",
            "45.254.44.0/22",
            "46.244.29.160/28",
            "57.72.72.0/22",
            "57.92.64.0/20",
            "59.153.88.0/22",
            "59.153.108.0/22",
            "61.4.64.0/20",
            "61.29.251.0/24",
            "65.18.112.0/20",
            "69.160.0.0/19",
            "74.50.208.0/21",
            "103.13.32.0/22",
            "103.25.12.0/22",
            "103.25.76.0/22",
            "103.25.240.0/22",
            "103.27.116.0/22",
            "103.29.90.0/23",
            "103.30.242.240/28",
            "103.30.243.0/28",
            "103.42.216.0/22",
            "103.47.184.0/23",
            "103.52.12.0/22",
            "103.52.228.0/22",
            "103.55.0.0/24",
            "103.55.3.0/24",
            "103.61.8.0/22",
            "103.64.20.0/22",
            "103.68.224.0/22",
            "103.69.248.0/22",
            "103.70.216.0/22",
            "103.70.249.0/24",
            "103.71.248.0/22",
            "103.73.236.0/22",
            "103.76.179.0/24",
            "103.76.184.0/23",
            "103.77.201.0/24",
            "103.80.36.0/22",
            "103.81.113.0/24",
            "103.81.114.0/23",
            "103.82.232.0/24",
            "103.83.34.0/23",
            "103.83.188.0/22",
            "103.85.104.0/22",
            "103.88.48.0/22",
            "103.89.48.0/22",
            "103.89.176.0/21",
            "103.94.52.0/22",
            "103.94.68.0/22",
            "103.94.144.0/22",
            "103.96.230.0/23",
            "103.96.232.0/24",
            "103.97.110.0/24",
            "103.99.28.0/22",
            "103.101.16.0/22",
            "103.103.194.0/24",
            "103.105.172.0/22",
            "103.108.104.0/22",
            "103.110.196.0/22",
            "103.110.221.0/24",
            "103.113.84.0/22",
            "103.115.4.0/23",
            "103.115.6.0/24",
            "103.115.23.0/24",
            "103.115.214.0/23",
            "103.116.12.0/24",
            "103.116.57.0/24",
            "103.116.58.0/23",
            "103.116.159.0/24",
            "103.116.190.0/23",
            "103.116.192.0/23",
            "103.116.194.0/24",
            "103.116.236.0/22",
            "103.121.64.0/22",
            "103.121.158.0/24",
            "103.121.224.0/21",
            "103.124.158.0/23",
            "103.129.76.0/22",
            "103.133.242.0/23",
            "103.134.204.0/22",
            "103.135.37.0/24",
            "103.135.216.0/22",
            "103.136.132.0/22",
            "103.137.86.0/24",
            "103.138.252.0/23",
            "103.139.100.0/23",
            "103.139.194.0/24",
            "103.139.206.0/24",
            "103.139.208.0/23",
            "103.142.39.0/24",
            "103.142.118.0/24",
            "103.142.144.0/23",
            "103.143.200.0/23",
            "103.143.246.0/23",
            "103.144.8.0/23",
            "103.144.224.0/23",
            "103.145.120.0/23",
            "103.145.186.0/24",
            "103.146.48.0/23",
            "103.146.66.0/23",
            "103.146.116.0/24",
            "103.148.104.0/24",
            "103.149.50.0/23",
            "103.150.58.0/24",
            "103.150.78.0/23",
            "103.151.8.0/23",
            "103.153.13.0/24",
            "103.153.202.0/24",
            "103.154.240.0/23",
            "103.155.10.0/23",
            "103.156.154.0/23",
            "103.157.0.0/23",
            "103.197.196.0/22",
            "103.198.148.0/22",
            "103.200.132.0/22",
            "103.203.132.0/22",
            "103.204.16.0/22",
            "103.204.100.0/22",
            "103.206.173.0/24",
            "103.213.30.0/24",
            "103.213.228.0/24",
            "103.215.192.0/22",
            "103.217.156.0/22",
            "103.219.108.0/22",
            "103.219.156.0/22",
            "103.231.92.0/22",
            "103.233.204.0/22",
            "103.242.96.0/22",
            "103.255.172.0/22",
            "104.244.99.208/29",
            "116.206.136.0/22",
            "117.18.228.0/22",
            "117.55.248.0/22",
            "117.55.252.0/23",
            "121.54.164.0/22",
            "122.10.248.0/23",
            "122.248.96.0/19",
            "123.253.20.0/22",
            "123.253.228.0/22",
            "136.228.160.0/20",
            "137.83.231.0/24",
            "143.92.40.0/21",
            "146.88.41.0/24",
            "154.208.1.0/24",
            "157.119.76.0/22",
            "157.167.35.0/24",
            "157.240.173.0/24",
            "157.250.128.32/27",
            "157.250.128.64/27",
            "157.250.162.192/27",
            "162.245.127.0/24",
            "180.235.116.0/22",
            "182.255.52.0/22",
            "185.133.212.0/22",
            "185.205.140.0/22",
            "193.220.38.248/32",
            "193.220.123.128/29",
            "193.220.126.16/28",
            "193.220.126.168/29",
            "193.220.126.176/29",
            "202.53.156.0/22",
            "202.133.84.0/22",
            "202.165.80.0/20",
            "202.191.96.0/20",
            "203.81.64.0/19",
            "203.81.160.0/20",
            "203.96.240.0/22",
            "203.109.36.0/22",
            "203.109.48.0/22",
            "203.166.158.0/23",
            "203.215.60.0/22",
            "208.127.168.224/27",
            "208.127.212.0/24",
            "209.130.175.69/32",
            "209.130.175.237/32",
            "210.14.96.0/20",
            "210.89.75.176/29",
            "210.89.78.240/29"
        ];

        $ip = ip2long($ip);
        foreach ($ranges as $key => $range) {
            list($subnet, $bits) = explode('/', $range);

            if ($bits === null) {
                $bits = 32;
            }

            $subnet = ip2long($subnet);

            $mask = -1 << (32 - $bits);

            $subnet &= $mask;

            if (($ip & $mask) == $subnet) {
                return "true";
            }
        }
        return "false";
    }
    public function groupByWithPayDate()
    {
        $data = [];
        $transactions = Transaction::orderBy('pay_date', 'desc')->paginate(2)->groupBy('pay_date');

        if (count($transactions) > 0) {
            foreach ($transactions as $key => $value) {
                $data[] = ['date' => $key, 'transactions' => $value];
            }
        }

        return $this->responseSuccess($data, 'Transaction List with Date!');
    }

    // protected function encrypt($data)
// {
//     $cipher = 'AES-128-CBC';
//     $key = "ziju34gwzkj1s92z";
//     $iv = "0b1c2f345789ade6";

    //     $value = openssl_encrypt(
//         utf8_encode($data),
//         $cipher,
//         $key,
//         OPENSSL_RAW_DATA,
//         $iv
//     );

    //     if ($value === false) {
//         return response()->json(['error' => 'Could not encrypt the data.'], 422);
//     }

    //     return base64_encode($value);
// }

    // protected function decrypt($payload)
// {
//     $cipher = 'AES-128-CBC';
//     $key = "ziju34gwzkj1s92z";
//     $iv = "0b1c2f345789ade6";

    //     $decrypted = openssl_decrypt(base64_decode($payload), $cipher, $key, OPENSSL_RAW_DATA, $iv);

    //     if ($decrypted === false) {
//         return response()->json(['error' => 'Could not decrypt the data.'], 422);
//     }

    //     return $decrypted;
// }
}