<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
  protected const ALLOWED_LOCALIZATIONS = ['es', 'en'];

  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $localization = $request->header('Accept-Language');
    $localization = in_array($localization, self::ALLOWED_LOCALIZATIONS, true) ? $localization : 'es';
    app()->setLocale($localization);

    return $next($request);
  }
}
