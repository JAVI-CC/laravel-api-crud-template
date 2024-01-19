<?php

namespace Tests\Traits;

use App\Models\User;

trait GetResourceUser
{
  private function getResourceCollectionUsers($users): array
  {
    return $users->map(function ($user) {
      return [
        'id' => $user->id,
        'nombre' => $user->nombre,
        'apellidos' => $user->apellidos,
        "nombre_completo" => $user->nombre_completo,
        'email' => $user->email,
        'rol' =>  ['id' => $user->rol->id, 'nombre' => __($user->rol->nombre)],
        'is_admin' => $user->is_admin,
        'is_email_verified' => $user->is_email_verified,
        'avatar_url' => $user->avatar_url,
      ];
    })->toArray();
  }

  private function getNewResourceUser(User $user, string $email = null): array
  {
    return [
      'id' => $user->id,
      'nombre' => $user->nombre,
      'apellidos' => $user->apellidos,
      "nombre_completo" => $user->nombre_completo,
      'email' => $email ? $email : $user->email,
      'rol' =>  ['id' => $user->rol->id, 'nombre' => __($user->rol->nombre)],
      'is_admin' => $user->is_admin,
    ];
  }

  // private function getResourceCollectionStructureJuego(): array
  // {
  //     return [
  //         '*' => [
  //             "nombre",
  //             "descripcion",
  //             "desarrolladora" => ["nombre", "slug"],
  //             "generos" => ['*' =>  ["nombre", "slug"]],
  //             "fecha",
  //             "slug",
  //             "imagen"
  //         ]
  //     ];
  // }
}
