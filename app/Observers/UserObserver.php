<?php

namespace App\Observers;

use App\Enums\CacheKeysEnum;
use App\Enums\DisksEnum;
use App\Models\User;
use App\Services\MediaService;
use App\Services\StrService;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
  /**
   * Handle the User "created" event.
   */
  public function created(User $user): void
  {
    Cache::forget(CacheKeysEnum::USER->value);
  }

  /**
   * Handle the User "updated" event.
   */
  public function updated(User $user): void
  {
    Cache::forget(CacheKeysEnum::USER->value);
  }

  /**
   * Handle the User "deleted" event.
   */
  public function deleted(User $user): void
  {
    $user->update([
      'email' => StrService::preventNamesDuplicates($user->email),
    ]);

    if ($user->avatar_name_file) {
      $mediaService = new MediaService(DisksEnum::AVATAR->value, $user->avatar_name_file_attr);
      $mediaService->deleteFile();
    }

    Cache::forget(CacheKeysEnum::USER->value);
  }

  /**
   * Handle the User "restored" event.
   */
  public function restored(User $user): void
  {
    //
  }

  /**
   * Handle the User "force deleted" event.
   */
  public function forceDeleted(User $user): void
  {
    //
  }
}
