<?php

namespace App\Traits;

trait HasAuthorizeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
