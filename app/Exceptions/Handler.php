<?php

namespace App\Exceptions;

use App\Models\LogError;
use App\Notifications\ReportNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Throwable;

class Handler extends ExceptionHandler
{

  /**
   * A list of the exception types that are not reported.
   *
   * @var array<int, class-string<\Throwable>>
   */
  protected $dontReport = [
    AuthorizationException::class,
  ];

  /**
   * The list of the inputs that are never flashed to the session on validation exceptions.
   *
   * @var array<int, string>
   */
  protected $dontFlash = [
    'current_password',
    'password',
    'password_confirmation',
  ];

  /**
   * Register the exception handling callbacks for the application.
   */
  public function register(): void
  {
    $this->reportable(function (Throwable $e) {
      //
    });
  }

  public function render($request, Throwable $exception): JsonResponse
  {
    $isServerError = true;

    if ($exception instanceof HttpResponseException && $isServerError) {
      $statusCode = $exception->getResponse()->getStatusCode();
      $statusCode != 401 ?: $isServerError = false;
    }

    if (config('app.env') == 'production' && $isServerError) {
      try {
        $report = LogError::create([
          'message' => $exception->getMessage(),
          'uri' => $request->getRequestUri(),
          'request_params' => $request->all(),
          'user_id' => auth()->user() ? auth()->user()->id : null
        ]);

        Notification::route('email', config('app.MAIL_TO_REPORT'))->notify(new ReportNotification($report));
      } catch (\Exception $e) {
      }

      if ($exception instanceof ModelNotFoundException && $request->is('api/*') /*Error 404*/) {
        return response()->json(['message' => __('No results have been found for the section:') . ' ' . basename($exception->getModel())], 404);
      } else if ($request->is('api/*') /*Error 500*/) {
        return response()->json(['message' => __('Internal Server Error. Please consult with the administrator')], 500);
      }
    }

    return parent::render($request, $exception);
  }
}
