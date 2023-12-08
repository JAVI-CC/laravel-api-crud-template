<?php

namespace Tests\Feature;

use App\Models\Rol;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Tests\Traits\CreateNewUser;
use Tests\Traits\GetResourceRol;

class RolTest extends TestCase
{
  use DatabaseMigrations, CreateNewUser, GetResourceRol;

  private const PATH = '/api/roles/';

  public function test_obtener_todos_los_roles(): void
  {
      $userAuth = $this->createNewUser(true);
      $roles = Rol::OrderBy('nombre')->get();
      Sanctum::actingAs($userAuth);

      $res = $this->getJson(self::PATH);

      $res->assertStatus(200);
      $res->assertExactJson($this->getResourceCollectionRoles($roles));
  }
}
