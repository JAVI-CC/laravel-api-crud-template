<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

trait HasFailedValidationRequest
{
    protected function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json(["message" => $validator->errors()], 422));
    }
}
