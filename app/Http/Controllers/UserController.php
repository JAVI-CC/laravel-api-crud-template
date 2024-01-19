<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\User\UserAddRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Rol;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
  public function index(): JsonResponse
  {
    $users = User::getAllUsers();

    return response()->json(UserResource::collection($users), 200);
  }

  public function show(User $user): JsonResponse
  {
    return response()->json(new UserResource($user), 200);
  }

  public function store(UserAddRequest $request): JsonResponse
  {
    $user = User::create($request->validated()); //observer

    event(new Registered($user));

    return response()->json(new UserResource($user), 201);
  }

  public function update(User $user, UserUpdateRequest $request): JsonResponse
  {
    if ($request->rol_id === Rol::USER_ID && $user->is_admin)
      $this->authorize('updateRolAdmin', [User::class, auth()->user()]);

    $user->update($request->only([
      $request->nombre ? 'nombre' : $user->nombre,
      $request->apellidos ? 'apellidos' : $user->apellidos,
      $request->email ? 'email' : $user->email,
      $request->rol_id ? 'rol_id' : $user->rol_id,
    ])); //observer

    return response()->json(new UserResource($user), 200);
  }

  public function destroy(User $user): JsonResponse
  {
    $user->delete(); //observer
    return response()->json([], 204);
  }

  public function exportUsersPDF()
  {
    $users = User::getAllUsers();

    $pdf = Pdf::loadView('exportpdf.users', compact('users'));
    return $pdf->download('users-list.pdf');
  }

  public function exportUsersExcel()
  {
    return Excel::download(new UsersExport(), 'users-list.xlsx');
  }
}
