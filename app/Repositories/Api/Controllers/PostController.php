<?php

namespace App\Repositories\Api\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Repositories\Api\BaseController;
use App\Repositories\Api\Services\PostService;
use App\Repositories\Api\Services\UploadService;
use App\Repositories\Api\Validators\PostValidator;

class PostController extends BaseController
{
    protected $validator;
    protected $service;
    protected $uploadService;
    protected $post_video_folder;

    public function __construct(PostValidator $validator, PostService $service, UploadService $uploadService)
    {
        $this->validator = $validator;
        $this->service = $service;
        $this->uploadService = $uploadService;
        $this->post_video_folder = "post-videos/";
    }

    public function create(Request $request)
    {
        $validator = $this->validator->create($request->all());

        if ($validator->fails()) {
            $errors = $this->getErrorObject($validator->errors());
            return $this->responseError($validator->errors()->first(), $errors, 422);
        }

        $attributes = $validator->validated();

        $post = $this->service->savePost($attributes, $this->post_video_folder, "hello");

        return $this->responseSuccess($post, 'Post Successfully!');
    }
}