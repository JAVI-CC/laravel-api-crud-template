<?php

namespace App\Http\Requests\User;

use App\Traits\HasAuthorizeRequest;
use App\Traits\HasFailedValidationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecoveryPasswordRequest extends FormRequest
{
  use HasAuthorizeRequest, HasFailedValidationRequest;

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array
  {
    return [
      'email' => ['required', 'string', 'email', Rule::exists('users', 'email')]
    ];
  }

  /**
   * Get the error messages for the defined validation rules.
   *
   * @return array<string, string>
   */
  public function messages(): array
  {
    return [
      'email.exists' => __('The email is not registered or is misspelled, try again'),
    ];
  }
}
