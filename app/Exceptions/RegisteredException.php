<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RegisteredException extends Exception
{
  public function __construct(
    string $message,
    int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
    ?Throwable $previous = null
  ) {
    parent::__construct($message, $code, $previous);
  }

  public function render(Request $request)
  {
    if ($request->isJson())
      return response()->json(['message' => __($this->message)], $this->code);
  }
}
