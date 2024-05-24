<?php

namespace Tests\Traits;

use App\Enums\RolTiposEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

trait CreateNewUser
{
  private function createNewUser(bool $isAdmin = false, bool $isUnverified = true, bool $isAvatarFile = false): User
  {
    $user = User::factory()->create([
      'nombre' => $isAdmin ? 'Admin testing' : 'User testing',
      'email' => $isAdmin ? 'admin@email.com' : 'user@email.com',
      'password' => bcrypt('12345678'),
      'rol_id' => $isAdmin ? RolTiposEnum::ADMIN->value : RolTiposEnum::USER->value,
      'email_verified_at' => $isUnverified ? now() : null,
      'avatar_name_file' => $isAvatarFile ? 'avatar.png' : null,
    ]);

    return $user;
  }

  private function createMutipleUser(int $count = 1): Collection
  {
    return User::factory($count)->unverified()->create();
  }
}
