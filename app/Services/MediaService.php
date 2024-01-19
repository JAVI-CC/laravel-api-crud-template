<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class MediaService
{
  // public static function cloudFolder(): string
  // {
  //   return [
  //     's3' => config('app.AWS_FOLDER'),
  //     'azure' => config('app.AZURE_FOLDER')
  //   ][config('app.FILESYSTEM_DISK')];
  // }

  public static function uploadFileBase64(string $path, string $base64): string
  {
      @list($ext, $fileData) = explode(';', $base64);
      @list(, $fileData) = explode(',', $fileData);

      Storage::disk(config('app.FILESYSTEM_DISK'))->put($path, base64_decode($fileData));

      return $path;
  }
}
