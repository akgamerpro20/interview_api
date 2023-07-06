<?php

use App\Repositories\Api\Controllers\PhoneController;
use App\Repositories\Api\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Repositories\Api\Controllers\TestingController;
use App\Repositories\Api\Controllers\Auth\AuthController;
use App\Repositories\Api\Controllers\TransactionController;
use App\Repositories\Api\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Login Register
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::prefix('posts')->group(function () {
    Route::post('video/approve', [PostController::class, 'ApproveVideo']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user/profile', [AuthController::class, 'userProfile']);
    Route::post('user/profile-update', [AuthController::class, 'userProfileUpdate']);
    Route::delete('user/delete', [AuthController::class, 'userDelete']);
    Route::get('user/logout', [AuthController::class, 'logout']);
    Route::post('user/change-password', [AuthController::class, 'userChangePassword']);
    Route::get('users', [AuthController::class, 'users']);

    Route::post('noti-create', [NotificationController::class, 'create']);

    Route::prefix('testing')->group(function () {
        Route::get('/', [TestingController::class, 'testing']);
        Route::get('/userPost/{id}', [TestingController::class, 'userPost']);
    });

    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'all']);
        Route::post('create-transaction', [TransactionController::class, 'create']);
        Route::post('create-transaction-with-job', [TransactionController::class, 'createWithJob']);
        Route::get('approve-payment/{tranId}', [TransactionController::class, 'approve']);
        Route::get('encryptData', [TransactionController::class, 'EncryptData']);
        Route::get('decryptData', [TransactionController::class, 'DecryptData']);
        Route::get('checkMyanmar', [TransactionController::class, 'checkMyanmar']);
        Route::get('groupByWithPayDate', [TransactionController::class, 'groupByWithPayDate']);
    });

    Route::prefix('phone')->group(function () {
        // Route::post('check-myanmar-phone', [PhoneController::class, 'checkPhNo']);
    });

    Route::prefix('posts')->group(function () {
        Route::post('create', [PostController::class, 'create']);
    });
});