<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminUserPolicy
{

    /**
     * Determine wheter the user c
     */
    public function compareRoleLevel(User $user, int $role): bool
    {
        if ($user->role->priority < $role) {
            return false;
        }
        return true;
    }
}
