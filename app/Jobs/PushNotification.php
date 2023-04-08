<?php

namespace App\Jobs;

use Log;
use App\Models\User;
use App\Models\DeviceToken;
use Illuminate\Bus\Queueable;
use App\Models\UserNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notification;

    /**
     * Create a new job instance.
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // if ($this->notification->type == 1) {
        //     $image = $this->notification->course_id ? image_path($this->notification->course->image) : Null;
        // } else {
        //     $image = $this->notification->course_id ? image_path($this->notification->certificate->image) : Null;
        // }

        $msg = array
        (
            'id'            => $this->notification->id,
            'title'         => $this->notification->title,
            'body'          => $this->notification->message,
            'image'         => null,
            // 'course_id'     => $this->notification->course_id ?? 0,
            'noti_type'     => $this->notification->noti_type
        );

        if($this->notification->sent_to === 1){
            $android_fields = [
                'to' => "/topics/ALL",
                'priority' => 'high',
                'data' => $msg
            ];

            Log::info('Push Notification For Android: '. json_encode($android_fields));
            // send_fcm_notification($android_fields);

            $ios_fields = [
                'to' => "/topics/ios_all",
                'notification' => [
                    'title' => $this->notification->title,
                    'body'  => $this->notification->message,
                ],
                'data' => [
                    'image'     => null,
                    // 'course_id' => $this->notification->course_id ?? 0,
                    'type'      => $this->notification->noti_type
                ]
            ];

            Log::info('Push Notification For IOS: '. json_encode($ios_fields));
            // send_fcm_notification($ios_fields);
        }else{
            $users = User::get();

            foreach ($users as $key => $user) {
                $userNotification = UserNotification::create([
                    'user_id' => $user->id,
                    'noti_id' => $this->notification->id,
                ]);

                if (DeviceToken::where('user_id', $user->id)->exists()) {
                    $deviceToken = DeviceToken::where('user_id', $user->id)->latest()->first();

                    $to = (array) $deviceToken->token;

                    $android_fields = [
                        'registration_ids' => $to,
                        'priority' => 'high',
                        'data' => $msg,
                    ];

                    Log::info('Push Notification With Device Token (Android): '. json_encode($android_fields));
                    // send_fcm_notification($android_fields);

                    $ios_fields = [
                        'registration_ids' => $to,
                        'notification' => [
                            'title' => $this->notification->title,
                            'body'  => $this->notification->message,
                        ],
                        'data' => [
                            'image'     => null,
                            // 'course_id' => $this->notification->course_id ?? 0,
                            'type'      => $this->notification->noti_type
                        ]
                    ];

                    Log::info('Push Notification With Device Token (IOS): '. json_encode($ios_fields));
                    // send_fcm_notification($ios_fields);

                    $this->notification->send_status = 1;
                    $this->notification->save();
                    $userNotification->sent = 1;
                    $userNotification->save();
                }
            }
        }
    }
}
