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