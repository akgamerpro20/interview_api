<?php

namespace App\Repositories\Api\Services;

use Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    protected $imageDir,
    $imagePath,
    $imageThumbPath;

    public function getFile($file, $imagePath)
    {
        $this->imageDir = public_path() . $imagePath;
        $this->imagePath = $imagePath;

        $name = $this->generateFileName($file);

        // For cloud storage
        $file->storeAs($this->imagePath, $name);

        return "{$this->imagePath}{$name}";
    }

    public function getFileVideo($file, $imagePath)
    {
        $this->imageDir = public_path() . $imagePath;
        $this->imagePath = $imagePath;

        $name = $this->generateFileName($file);

        // $file->storeAs($this->imagePath, $name);
        Storage::disk('do_spaces')->putFileAs($this->imagePath, $file, $name);

        return "{$name}";
    }

    /**
     * Get path thumbnail file.
     */
    public function getThumbFile($file, $imagePath)
    {
        $thumbFile = Image::make($file)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        $name = $this->generateFileName($file);

        $path = "{$imagePath}/{$name}";
        Storage::put($path, $thumbFile->encoded);

        return $path;
    }

    /**
     * Get the encrypted file.
     */
    public function getEncryptedFile($file, $imagePath)
    {
        $this->imagePath = $imagePath;

        $encryptedFile = $this->makeEncryptFile($file);
        $name = $this->generateFileName($file);

        // For cloud storage
        $path = "{$this->imagePath}/{$name}";
        Storage::put($path, $encryptedFile);

        return $path;
    }

    /**
     * Generate the image name
     */
    protected function generateFileName($file)
    {
        return time() . Str::random(6) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Generate the encrypt file name.
     */
    protected function generateEncryptFileName($file)
    {
        return time() . str_random(6);
    }

    protected function makeEncryptFile($file)
    {
        $key = "TkzLAkKwvgDPUeq7Mrw9SC5e8j55fFFz";
        $iv = "LnpUGYrcqS3Gx8Sm";

        $nsData = file_get_contents($file);
        // $length = strlen($nsData) % 16;

        // if ($length != 0) {
        //     $pad_length = strlen($nsData) + (16 - $length);
        //     $nsData = str_pad($nsData, $pad_length, ' ');
        // }

        $encryptedBody = openssl_encrypt(
            $nsData,
            'AES-256-CBC',
            $key,
            0,
            $iv
        );

        // return $encryptedBody;
        return $encryptedBody;
    }
}