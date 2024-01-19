<?php

namespace Tests\Traits;

use App\Models\User;

trait GetResourceAuth
{
  private function getNewResourceAuth(User $user, bool|null $isLogged = null, string $email = null): array
  {
    return [
      'id' => $user->id,
      'nombre' => $user->nombre,
      'apellidos' => $user->apellidos,
      "nombre_completo" => $user->nombre_completo,
      'email' => $email ? $email : $user->email,
      'rol' =>  ['id' => $user->rol->id, 'nombre' => __($user->rol->nombre)],
      'is_admin' => $user->is_admin,
      'is_email_verified' => $user->is_email_verified,
      'avatar_url' => $user->avatar_url,
      'is_logged' => $isLogged,
    ];
  }
}
