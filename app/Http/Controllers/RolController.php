<?php

namespace App\Http\Controllers;

use App\Http\Resources\SingleTraductionResource;
use App\Models\Rol;
use Illuminate\Http\JsonResponse;

class RolController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = Rol::orderBy('nombre')->get();
        return response()->json(SingleTraductionResource::collection($roles), 200);
    }
}
