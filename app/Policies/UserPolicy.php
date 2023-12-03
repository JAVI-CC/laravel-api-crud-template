<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function updateRolAdmin(User $user, ?User $model): bool|Response
    {
        if (User::countAdmins() === 1)
            return Response::deny(__('There must be at least 1 administrator'));

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool|Response
    {
        if ($user->id === $model->id)
            return Response::deny(__('You cannot eliminate yourself'));

        return true;
    }
}
