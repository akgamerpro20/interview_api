<?php

namespace App\Repositories\Api\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseController;

abstract class Status
{
    const SUCCESS = 1;
    const PENDING = 2;
    const FAILED = 3;
}

class TestingController extends BaseController
{
    public function testing()
    {
        $data = Post::class;
        return $data;
    }

    public function userPost($id)
    {
        $post = Post::find($id);
        return response()->json($post->user->email);
    }

    public function matchTest()
    {
        return match (3) {
            Status::PENDING => $this->pending(),
            Status::SUCCESS => $this->success(),
            Status::FAILED => $this->failed(),
        };
    }

    protected function pending()
    {
        return "pending";
    }

    protected function success()
    {
        return "success";
    }

    protected function failed()
    {
        return "failed";
    }
}