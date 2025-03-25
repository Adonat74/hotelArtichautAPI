<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Exception;

class CompareUserRoleService
{
    /**
     * Determine wheter the user c
     */
    public function compareUserRole(User $user, int $roleId): void
    {
        $role = Role::findOrFail($roleId);

        if ($user->role->priority < $role->priority) {
            throw new Exception("You can't add, modify nor delete a user with a bigger role than yours");
        }
    }
}
