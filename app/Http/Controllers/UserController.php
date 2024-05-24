<?php

namespace App\Http\Controllers;

use App\Enums\DisksEnum;
use App\Enums\RolTiposEnum;
use App\Exceptions\RegisteredException;
use App\Exports\UsersExport;
use App\Http\Requests\User\UserAddRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\MediaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
    DB::beginTransaction();

    $user = User::create(Arr::except($request->validated(), ['avatar_imagen_base64'])); //observer
    $mediaService = new MediaService(DisksEnum::AVATAR->value, $user->avatar_name_file_attr);

    if ($request->avatar_imagen_base64) {
      $mediaService->uploadFileBase64($request->avatar_imagen_base64);
      $user->update(['avatar_name_file' => $user->avatar_name_file_attr]);
    }

    try {
      event(new Registered($user));
    } catch (\Exception $e) {
      if ($request->avatar_imagen_base64)
        $mediaService->deleteFile();

      DB::rollBack();
      throw new RegisteredException($e->getMessage());
    }

    DB::commit();
    return response()->json(new UserResource($user), 201);
  }

  public function update(User $user, UserUpdateRequest $request): JsonResponse
  {
    if ($request->rol_id === RolTiposEnum::USER->value && $user->is_admin)
      $this->authorize('updateRolAdmin', [User::class, auth()->user()]);

    $user->update($request->only([
      $request->nombre ? 'nombre' : $user->nombre,
      $request->apellidos ? 'apellidos' : $user->apellidos,
      $request->email ? 'email' : $user->email,
      $request->rol_id ? 'rol_id' : $user->rol_id,
    ])); //observer

    if ($request->avatar_imagen_base64 || $request->avatar_is_delete_actually) {
      $mediaService = new MediaService(DisksEnum::AVATAR->value, $user->avatar_name_file_attr);
      if ($request->avatar_is_delete_actually && !$request->avatar_imagen_base64) {
        $mediaService->deleteFile();
        $user->update(['avatar_name_file' => null]);
      } else if ($request->avatar_imagen_base64) {
        $mediaService->uploadFileBase64($request->avatar_imagen_base64);
        $user->update(['avatar_name_file' => $user->avatar_name_file_attr]);
      }
    }

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
