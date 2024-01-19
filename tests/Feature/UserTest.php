<?php

namespace Tests\Feature;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;
use Tests\Traits\CreateNewUser;
use Tests\Traits\GetResourceUser;

class UserTest extends TestCase
{
  use DatabaseMigrations, GetResourceUser, CreateNewUser;

  private const PATH = '/api/user/';
  private const FAKE_STORAGE = 'avatars';

  public function test_obtener_todos_los_users(): void
  {
    $userAuth = $this->createNewUser(true);
    $this->createMutipleUser(5);
    $users = User::With(['rol'])->orderBy('nombre')->get();
    Sanctum::actingAs($userAuth);

    $res = $this->getJson(self::PATH);

    $res->assertStatus(200);
    $res->assertExactJson($this->getResourceCollectionUsers($users));
  }

  public function test_obtener_user_mediante_id(): void
  {
    $userAuth = $this->createNewUser(true);
    $user = $this->createNewUser();
    Sanctum::actingAs($userAuth);

    $res = $this->getJson(self::PATH . $user->id);

    $res->assertStatus(200);
    $res->assertJsonCount(9);
    $res->assertJson($this->getNewResourceUser($user));
  }

  public function test_crear_user(): void
  {
    Storage::fake(self::FAKE_STORAGE);
    Sanctum::actingAs($this->createNewUser(true));
    $data = [
      'nombre' => 'Sr.Test',
      'apellidos' => 'Laravel Ape',
      'email' => 'test@laravel.com',
      'password' => 'Test-1234',
      'password_confirmation' => 'Test-1234',
      'rol_id' => 'fcad485b-3a80-4237-a56a-0f7f29d7b148',
      'avatar_imagen_base64' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPj/HwADBwIAMCbHYQAAAABJRU5ErkJggg==',
    ];

    $res = $this->postJson(self::PATH, $data);
    $user = User::Where('email', 'test@laravel.com')->first();

    $this->assertEquals($data['nombre'], $user->nombre);
    $this->assertEquals($data['apellidos'], $user->apellidos);
    $this->assertEquals($data['email'], $user->email);
    $this->assertEquals($data['rol_id'], $user->rol_id);
    $this->assertEquals($user->id . '.png', $user->avatar_name_file);
    $this->assertNull($user->email_verified_at);
    Storage::disk(self::FAKE_STORAGE)->assertExists($user->id . '.png');
    $res->assertStatus(201);
    $res->assertJsonCount(9);
    $this->assertDatabaseCount(User::class, 2);
    $res->assertJson($this->getNewResourceUser($user));
    Storage::fake(self::FAKE_STORAGE)->deleteDirectory(self::FAKE_STORAGE);
  }

  public function test_actualizar_user(): void
  {
    Storage::fake(self::FAKE_STORAGE);
    Sanctum::actingAs($this->createNewUser(true, true));
    $user = $this->createNewUser(false, false, true);
    UploadedFile::fake()->image($user->id . '.png', 400, 400)->size(100);
    $data = [
      'nombre' => 'Upgrade',
      'apellidos' => 'Laravel Update',
      'email' => 'testupdate@laravel.com',
      'rol_id' => '345dda73-cfbe-4626-aa6f-351b55d538bf',
      'avatar_imagen_base64' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPj/HwADBwIAMCbHYQAAAABJRU5ErkJggg==',
      'avatar_is_delete_actually' => true,
    ];

    $res = $this->putJson(self::PATH . $user->id, $data);
    $updateUser = User::Where('email', 'testupdate@laravel.com')->first();

    $this->assertEquals($data['nombre'], $updateUser->nombre);
    $this->assertEquals($data['apellidos'], $updateUser->apellidos);
    $this->assertEquals($data['email'], $updateUser->email);
    $this->assertEquals($data['rol_id'], $updateUser->rol_id);
    $this->assertEquals($user->id . '.png', $updateUser->avatar_name_file);
    $this->assertNull($updateUser->email_verified_at);
    Storage::disk(self::FAKE_STORAGE)->assertExists($user->id . '.png');
    $res->assertStatus(200);
    $res->assertJsonCount(9);
    $this->assertDatabaseCount(User::class, 2);
    $res->assertJson($this->getNewResourceUser($updateUser));
    Storage::fake(self::FAKE_STORAGE)->deleteDirectory(self::FAKE_STORAGE);
  }

  public function test_eliminar_user(): void
  {
    Storage::fake(self::FAKE_STORAGE);
    Sanctum::actingAs($this->createNewUser(true));
    $user = $this->createNewUser();
    UploadedFile::fake()->image($user->id . '.png', 400, 400)->size(100);

    $res = $this->deleteJson(self::PATH . $user->id);
    Storage::disk(self::FAKE_STORAGE)->assertMissing($user->id . '.png');

    $res->assertStatus(204);
    $this->assertSoftDeleted(User::class, ['id' => $user->id]);
    Storage::fake(self::FAKE_STORAGE)->deleteDirectory(self::FAKE_STORAGE);
  }

  public function test_export_excel_users(): void
  {
    Excel::fake();
    $user = $this->createNewUser();
    Sanctum::actingAs($this->createNewUser(true));

    $res = $this->getJson(self::PATH . 'export/excel');

    $res->assertStatus(200);
    Excel::assertDownloaded('users-list.xlsx', function (UsersExport $export) use ($user) {
      return $export->view()->getData()['users']->contains('id', $user->id);
    });
  }

  public function test_export_pdf_users(): void
  {
    Sanctum::actingAs($this->createNewUser(true));

    $res = $this->getJson(self::PATH . 'export/pdf');

    $res->assertStatus(200);
    $this->assertNotEmpty($res->getContent());
    $this->assertEquals('application/pdf', $res->headers->get('Content-Type'));
    $this->assertEquals('attachment; filename="users-list.pdf"', $res->headers->get('Content-Disposition'));
  }
}
