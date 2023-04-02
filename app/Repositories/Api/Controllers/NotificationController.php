<?php

namespace App\Repositories\Api\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Api\BaseController;
use App\Repositories\Api\Validators\NotiValidator;

class NotificationController extends BaseController
{
    protected $validator;

    public function __construct(NotiValidator $validator)
    {
        $this->validator = $validator;
    }

    public function create(Request $request)
    {
        $validator = $this->validator->create($request->all());

        if ($validator->fails()) {
            $errors = $this->getErrorObject($validator->errors());
            return $this->responseError($validator->errors()->first(), $errors, 422);
        }

        $attributes = $validator->validated();

        if(is_string($attributes['sent_to']) || is_string($attributes['noti_type'])){
            return $this->responseError("Sent To & Noti Type must be integer, not String.", null, 422);
        }

        $msg = array
        (
            'title'         => $attributes['title'],
            'message'       => $attributes['message'],
            'image'         => $attributes['image'] ? image_path($attributes['image']) :null,
            // 'course_id'     => $request->course_id ?? 0,
        );

        $fields = [
            'to' => "/topics/All",
            'priority' => 'high',
            'data' => $msg
        ];
        return response()->json($fields);

        // resolve(\App\Services\PushNotificationService::class)->send($fields);	
        
        return response()->json($attributes);
    }
}
