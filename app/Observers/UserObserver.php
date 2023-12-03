<?php

namespace App\Observers;

use App\Models\User;
use App\Services\StrService;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Cache::forget(User::CACHE_KEY);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        Cache::forget(User::CACHE_KEY);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $user->update([
            'email' => StrService::preventNamesDuplicates($user->email),
        ]);

        Cache::forget(User::CACHE_KEY);
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
