<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\MediaService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, HasUuids, Notifiable, SoftDeletes;

  const CACHE_KEY = 'users';
  const DISK_AVATARS = 'avatars';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'nombre',
    'apellidos',
    'email',
    'password',
    'avatar_name_file',
    'email_verified_at',
    'rol_id',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  //Relacion uno a muchos (inversa)
  public function rol(): BelongsTo
  {
    return $this->belongsTo(Rol::class);
  }
  //Fin Relacion uno a muchos (inversa)

  //Attributes
  protected function nombreCompleto(): Attribute
  {
    return Attribute::make(
      get: fn () => $this->nombre . ' ' . $this->apellidos,
    );
  }

  protected function isAdmin(): Attribute
  {
    return Attribute::make(
      get: fn () => $this->rol->id === Rol::ADMIN_ID,
    );
  }

  protected function isEmailVerified(): Attribute
  {
    return Attribute::make(
      get: fn () => $this->email_verified_at ? true : false,
    );
  }

  protected function avatarNameFileAttr(): Attribute
  {
    return Attribute::make(
      get: fn () => $this->id . '.png',
    );
  }

  protected function avatarUrl(): Attribute
  {
    $avatarMedia = new MediaService(self::DISK_AVATARS, $this->avatar_name_file);

    return Attribute::make(
      get: fn () => $this->avatar_name_file
        ? $avatarMedia->getUrlFile()
        : asset('images_backend/avatar_default.png')
    );
  }
  //Fin Attributes

  //Funciones
  public static function findByEmail(string $email): User
  {
    return User::where('email', $email)->first();
  }

  public static function countAdmins(): int
  {
    return self::where('rol_id', ROL::ADMIN_ID)->count();
  }

  public static function getAllUsers(): Collection
  {
    return Cache::remember(User::CACHE_KEY, now()->addDay(), function () {
      return User::With(['rol'])->orderBy('nombre')->get();
    });
  }

  public function generateToken()
  {
    return 'Bearer ' . $this->createToken(config('app.name'))->plainTextToken;
  }
  //Fin Funciones
}
