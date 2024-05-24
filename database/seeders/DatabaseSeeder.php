<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\DisksEnum;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    $mediaService = new MediaService(DisksEnum::AVATAR->value);
    $mediaService->cleanDirectory();

    $this->call([
      RolSeeder::class,
      UserSeeder::class
    ]);
  }
}
