<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public function fileUpload($file, $directory = 'img')
    {

        $mime = $file->getClientOriginalExtension();
        $random = Str::random(64).'.'.$mime;
        //add name into this
        $path = $file->storeAs($directory, $random, 'public');

        //remove storage and add in full_image
        return ['path' => '/storage/'.$path];

    }

    public function fileDelete($filePath)
    {
        $newPath = str_replace('/storage/', '', $filePath);
        Storage::disk('public')->delete($newPath);
    }
}
