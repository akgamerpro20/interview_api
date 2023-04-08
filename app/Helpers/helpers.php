<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadImageFile')) {

	function uploadImageFile($file, $imagePath)
	{
		$imageDir = public_path() . $imagePath;

		$name = Str::random(6).'.'.$file->getClientOriginalExtension();
        
        $file->storeAs($imagePath, $name);

        return "{$imagePath}{$name}";
	}
}

if (!function_exists('image_path')) {

	function image_path($value, $default = 1) 
	{
		return is_null($value) ? asset("../img/no-user.png"): Storage::url($value);
	}
}

if (!function_exists('deleteImage')) {

	function deleteImage($imagePath) 
	{
		\Storage::delete($imagePath);
	}
}

if (!function_exists('send_fcm_notification')) {
	function send_fcm_notification($field)
	{

		$fcmApiKey = config('services.fcm.key');

		$url = url('https://fcm.googleapis.com/fcm/send');

		$headers = array(
			'Authorization: key=' . $fcmApiKey,
			'Content-Type: application/json'
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
		$result = curl_exec($ch);

		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		curl_close($ch);

		// return json_decode($result);
	}
}