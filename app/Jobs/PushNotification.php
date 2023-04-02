<?php

namespace App\Jobs;

use App\Models\User;
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
        $users = User::get();

        foreach ($users as $key => $user) {
            $userNotification = UserNotification::create([
                'user_id' => $user->id,
                'notification_id' => $this->notification->id,
            ]);

             if (DeviceToken::where('user_id', $user->id)->exists()) {
                $deviceToken = DeviceToken::where('user_id', $user->id)->latest()->first();

                $to = (array) $deviceToken->token;

                $msg = array
                (
                    'id' => $this->notification->id,
                    'title' => $this->notification->title_en,
                    'body'   => $this->notification->message_en
                   
                    // 'title_mm' => $this->notification->title_mm,
                    // 'message_mm'   => $this->notification->message_mm,
                    // 'type' => $this->notification->type,
                    // 'book_id' => $this->notification->book_id,
                );

                $noti = array (
                    'title' => $this->notification->title_en,
                    'body'   => $this->notification->message_en
                );

                $fields = [
                    'registration_ids' => $to,
                    'priority' => 'high',
                    'data' => $msg,
                    "direct_boot_ok" => true,
                    "notification" => $noti
                ];

                send_fcm_notification($fields);

                $this->notification->sent_status = 1;
                $this->notification->save();
                $userNotification->sent = 1;
                $userNotification->save();
            }
        }
    }
}
