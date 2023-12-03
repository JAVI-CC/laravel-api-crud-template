<?php

namespace App\Http\Requests\User;

use App\Traits\HasAuthorizeRequest;
use App\Traits\HasFailedValidationRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserAddRequest extends FormRequest
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
            'nombre' => ['required', 'string', 'min:3', 'max:255'],
            'apellidos' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'max:255', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'rol_id' => ['required', 'string', Rule::exists('roles', 'id')],
        ];
    }
}
