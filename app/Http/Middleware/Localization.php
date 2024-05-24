<?php

namespace App\Http\Middleware;

use App\Enums\LocalizationsEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $localization = $request->header('Accept-Language');
    $localization = in_array($localization, LocalizationsEnum::toArray(), true) ? $localization : LocalizationsEnum::ES->value;
    app()->setLocale($localization);

    return $next($request);
  }
}
