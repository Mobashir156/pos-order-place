<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

function uploadImage(UploadedFile $file, $path, $disk = 'public')
{
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

    $uploaded = Storage::disk($disk)->putFileAs($path, $file, $filename);

    if ($uploaded) {
        return $filename;
    }

    return false;
}
