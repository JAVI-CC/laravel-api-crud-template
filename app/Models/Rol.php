<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
  use HasFactory, HasUuids;

  public $timestamps = false;

  protected $table = 'roles';

  //Relacion uno a muchos (inversa)
  public function users(): HasMany
  {
    return $this->hasMany(User::class);
  }
  //Fin Relacion uno a muchos (inversa)
}
