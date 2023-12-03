<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    use HasFactory, HasUuids;

    const ADMIN_ID = '345dda73-cfbe-4626-aa6f-351b55d538bf';
    const USER_ID = 'fcad485b-3a80-4237-a56a-0f7f29d7b148';

    public $timestamps = false;

    protected $table = 'roles';

    //Relacion uno a muchos (inversa)
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    //Fin Relacion uno a muchos (inversa)
}
