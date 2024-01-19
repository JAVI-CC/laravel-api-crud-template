<?php

namespace App\Http\Controllers;

use App\Notifications\VerifiedNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
  public function sendVerificationEmail(Request $request)
  {
    if ($request->user()->hasVerifiedEmail()) {
      auth()->user()->notify(new VerifiedNotification(true));
      return response()->json(['message' => __('Email already verified')], 200);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => __('Email forwarded successfully')], 200);
  }

  public function verify(EmailVerificationRequest $request)
  {
    auth()->user()->notify(new VerifiedNotification(true));

    if ($request->user()->hasVerifiedEmail())
      return response()->json(['message' => __('Email already verified')], 200);

    if ($request->user()->markEmailAsVerified())
      event(new Verified($request->user()));

    return response()->json(['message' => __('Email has been verified')], 200);
  }
}
