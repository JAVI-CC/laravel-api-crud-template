<?php

namespace Tests\Traits;

trait GetResourceRol
{
  private function getResourceCollectionRoles($roles): array
  {
    return $roles->map(function ($rol) {
      return [
        'id' => $rol->id,
        'nombre' => __($rol->nombre)
      ];
    })->toArray();
  }
}
