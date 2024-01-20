<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class MediaService
{

  public function __construct(private string $nameDisk, private string|null $nameFile = null)
  {
  }

  // public static function cloudFolder(): string
  // {
  //   return [
  //     's3' => config('app.AWS_FOLDER'),
  //     'azure' => config('app.AZURE_FOLDER')
  //   ][config('app.FILESYSTEM_DISK')];
  // }

  public function uploadFileBase64(string $base64): string
  {
    @list($ext, $fileData) = explode(';', $base64);
    @list(, $fileData) = explode(',', $fileData);

    Storage::disk($this->nameDisk)->put($this->nameFile, base64_decode($fileData));

    return $this->nameFile . $ext;
  }

  public function deleteFile(): bool
  {
    return Storage::disk($this->nameDisk)->delete($this->nameFile);
  }

  public function getUrlFile(): string
  {
    return Storage::disk($this->nameDisk)->url($this->nameFile);
  }

  public function cleanDirectory(): void
  {
    $allFiles = Storage::disk($this->nameDisk)->allFiles();

    if (false !== $key = array_search('.gitignore', $allFiles))
      unset($allFiles[$key]);

    foreach ($allFiles as $file)
      Storage::disk($this->nameDisk)->delete($file);
  }
}
