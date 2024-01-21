<?php

namespace App\Http\Controllers;

use App\Exceptions\RecoveryPasswordException;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RecoveryPasswordRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use App\Notifications\RecoveryPasswordNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function login(LoginRequest $request): JsonResponse
  {
    if (!Auth::attempt($request->only('email', 'password')))
      return response()->json(['message' => __('Wrong username or password')], 401);

    auth()->user()->is_logged = true;
    auth()->user()->access_token = auth()->user()->generateToken();
    return response()->json(new AuthResource(auth()->user()), 200);
  }

  public function check(): JsonResponse
  {
    auth()->user()->is_logged = true;
    return response()->json(new AuthResource(auth()->user()), 200);
  }

  public function logout(): JsonResponse
  {
    auth()->user()->currentAccessToken()->delete();
    return response()->json([], 204);
  }

  public function changePassword(ChangePasswordRequest $request): JsonResponse
  {
    //Actualizo de la siguiente manera para que no entre en el observer
    User::Where('id', auth()->user()->id)->update(['password' => Hash::make($request->password)]);
    return response()->json(['message' => __('The password has been changed successfully')], 200);
  }

  public function recoveryPassword(RecoveryPasswordRequest $request): JsonResponse
  {
    $user = User::findByEmail($request->email);

    try {
      $user->notify(new RecoveryPasswordNotification());
    } catch (\Exception $e) {
      throw new RecoveryPasswordException();
    }

    return response()->json(['message' => __('In a few moments you will receive an email to reset your password. Check your mailbox')], 200);
  }
}
