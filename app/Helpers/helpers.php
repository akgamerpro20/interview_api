<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadImageFile')) {

	function uploadImageFile($file, $imagePath)
	{
		$imageDir = public_path() . $imagePath;

		$name = Str::random(6) . '.' . $file->getClientOriginalExtension();

		$file->storeAs($imagePath, $name);

		return "{$imagePath}{$name}";
	}
}

if (!function_exists('image_path')) {

	function image_path($value, $default = 1)
	{
		return is_null($value) ? asset("../img/no-user.png") : Storage::url($value);
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

	if (!function_exists('validate_mm_phone')) {
		function validate_mm_phone($phone)
		{
			if (mpt_check($phone) || telenor_check($phone) || ooredoo_check($phone) || mytel_check($phone) || mectel_check($phone)) {
				return true;
			}
			return false;
		}
	}

	if (!function_exists('mpt_check')) {
		function mpt_check($number)
		{
			return preg_match(
				'/^(09|9|\+?959)(2[0-4]\d{5}|5[0-6]\d{5}|8[13-7]\d{5}|3[0-369]\d{6}|34\d{7}|4[1379]\d{6}|73\d{6}|91\d{6}|25\d{7}|26\d{7}|40\d{7}|42\d{7}|44\d{7}|45\d{7}||88\d{7}|89\d{7})$/',
				$number
			) ? true : false;
		}
	}

	/**
	 * Validation telenor phone number
	 */
	if (!function_exists('telenor_check')) {
		function telenor_check($number)
		{
			return preg_match(
				'/^(097|9|\+?9597)(9|8|7|6|5|4|3)\d{7}$/',
				$number
			) ? true : false;
		}
	}

	/**
	 * Validation ooredoo phone number
	 */
	if (!function_exists('ooredoo_check')) {
		function ooredoo_check($number)
		{
			return preg_match(
				'/^(099|9|\+?9599)(9|8|7|6|5|4|3)\d{7}$/',
				$number
			) ? true : false;
		}
	}

	/**
	 * Validation MYTEL phone number
	 */
	if (!function_exists('mytel_check')) {
		function mytel_check($number)
		{
			return preg_match(
				'/^(096|9|\+?9596)(9|8|7|6|5|)\d{7}$/',
				$number
			) ? true : false;
		}
	}

	/**
	 * Validation mectel phone number
	 */
	if (!function_exists('mectel_check')) {
		function mectel_check($number)
		{
			return preg_match(
				'/^(093|9|\+?9593)(0|1|2|3|4|5|6)(\d{6}|\d{7})$/',
				$number
			) ? true : false;
		}
	}

	function validate_number($phone_number)
	{
		return preg_match(
			'/^[0-9]{11}+$/',
			$phone_number
		) ? true : false;
	}
}