<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogError extends Model
{
  use HasFactory, HasUuids;

  protected $table = "log_errors";

  protected $fillable = [
    'message',
    'uri',
    'request_params',
    'user_id'
  ];

  protected $casts = [
    'request_params' => 'array',
  ];

  //Relacion uno a muchos (inversa)
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
  //Fin Relacion uno a muchos (inversa)
}
