<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      "id" => $this->id,
      "nombre" => $this->nombre,
      "apellidos" => $this->apellidos,
      "nombre_completo" => $this->nombre_completo,
      "email" => $this->email,
      "is_admin" => $this->is_admin,
      "is_email_verified" => $this->is_email_verified,
      "rol" => new SingleTraductionResource($this->rol),
      "avatar_url" => $this->avatar_url,
      "is_logged" => $this->is_logged,
      "token" => $this->access_token,
    ];
  }
}
