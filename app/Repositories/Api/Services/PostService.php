<?php

namespace App\Repositories\Api\Services;

use App\Models\Post;
use App\Models\Streaming;

class PostService
{
    public function savePost(array $params, string $post_video_folder, string $video_name): Post
    {
        $post = Post::create([
            "user_id" => auth()->user()->id,
            "text" => $params['text'],
            "video_path" => file_path($post_video_folder . $video_name)
        ]);

        $this->saveStreaming($params, $post_video_folder . $video_name);

        return $post;
    }

    protected function saveStreaming(array $params, string $videoPath): void
    {
        Streaming::create([
            "name" => $params['text'],
            "path" => $videoPath,
            "status" => "up",
            "type" => "post_video",
            "hd" => 0,
        ]);
    }

    public function videoCurl($video_id, $video_path, $video_name)
    {
        $secret_key = "ykMhA6gXTgSqaW3S";
        $hash_string = $video_name . $video_id;
        $hash_value = hash_hmac("sha1", $hash_string, $secret_key);

        $request = [
            "name" => $video_name,
            "path" => $video_path,
            "video_id" => $video_id,
            "token" => $hash_value
        ];

        $headers = array(
            "Accept: application/json",
            "Content-type: application/json",
        );

        $payload = json_encode($request);
        $url = "http://tcms.mizzimaburmese.com/api/upload";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_exec($ch);
        curl_close($ch);

        // $result = json_decode($response, true);
        // return $result;
    }
}