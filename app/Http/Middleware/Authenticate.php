<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
  /**
   * Get the path the user should be redirected to when they are not authenticated.
   */
  protected function redirectTo(Request $request): ?string
  {
    return $request->expectsJson() ? null : route('login');
  }

  protected function unauthenticated($request, array $guards): JsonResponse
  {
    abort(response()->json(['message' => __('You are not authenticated')], 401));
  }
}
