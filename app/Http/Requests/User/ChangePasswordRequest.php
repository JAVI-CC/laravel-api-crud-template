<?php

namespace App\Http\Requests\User;

use App\Traits\HasAuthorizeRequest;
use App\Traits\HasFailedValidationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'password' => ['required', 'string', 'max:255', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()]
        ];
    }
}
