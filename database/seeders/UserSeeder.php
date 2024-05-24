<?php

namespace Database\Seeders;

use App\Enums\RolTiposEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    User::factory()->create([
      'email' => 'admin@email.com',
      'rol_id' => RolTiposEnum::ADMIN->value
    ]);

    User::factory()->count(4)->create();
  }
}
