<?php

namespace Tests\Traits;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

trait CreateNewUser
{
    private function createNewUser(bool $isAdmin = false, bool $isUnverified = true): User
    {
        $user = User::factory()->create([
            'nombre' => $isAdmin ? 'Admin testing' : 'User testing',
            'email' => $isAdmin ? 'admin@email.com' : 'user@email.com',
            'password' => bcrypt('12345678'),
            'rol_id' => $isAdmin ? Rol::ADMIN_ID : Rol::USER_ID,
            'email_verified_at' => $isUnverified ? now() : null,
        ]);

        return $user;
    }

    private function createMutipleUser(int $count = 1): Collection
    {
        return User::factory($count)->unverified()->create();
    }
}
