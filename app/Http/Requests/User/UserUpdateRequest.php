<?php

namespace App\Http\Requests\User;

use App\Traits\HasAuthorizeRequest;
use App\Traits\HasFailedValidationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
  use HasAuthorizeRequest, HasFailedValidationRequest;

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'nombre' => ['nullable', 'string', 'min:3', 'max:255'],
      'apellidos' => ['nullable', 'string', 'min:3', 'max:255'],
      'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id, 'id')],
      'avatar_imagen_base64' => ['nullable', 'base64mimes:jpg,jpeg,png', 'base64max:4096'],
      'avatar_is_delete_actually' => ['nullable', 'boolean'],
      'rol_id' => ['nullable', 'string', Rule::exists('roles', 'id')],
    ];
  }
}
