<?php

namespace App\Http\Requests\User;

use App\Traits\HasAuthorizeRequest;
use App\Traits\HasFailedValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
      'email' => ['required', 'string', 'email', 'max:255'],
      'password' => ['required', 'string', 'min:8', 'max:255'],
    ];
  }
}
