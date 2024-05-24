<?php

namespace Database\Factories;

use App\Enums\RolTiposEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  protected static ?string $password;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'nombre' => fake()->firstName(),
      'apellidos' => fake()->lastName(),
      'email' => fake()->unique()->safeEmail(),
      'email_verified_at' => now(),
      'avatar_name_file' => /*fake()->boolean(50) ? fake()->uuid() . '.png' :*/ null,
      'password' => static::$password ??= Hash::make('password'),
      'remember_token' => Str::random(10),
      'rol_id' => RolTiposEnum::USER->value,
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   */
  public function unverified(): static
  {
    return $this->state(fn (array $attributes) => [
      'email_verified_at' => null,
    ]);
  }
}
