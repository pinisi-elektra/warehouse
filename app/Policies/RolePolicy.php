<?php

namespace App\Policies;

use App\Helpers\RoleList;
use App\Models\User;

class RolePolicy extends DefaultWarehousePolicy
{
    public function viewAny(User $user): bool
    {
        if ($user->isRoleMatch(RoleList::WAREHOUSE_ADMIN)) return false;

        return parent::viewAny($user);
    }

    public function view(User $user, $model): bool
    {
        if ($user->isRoleMatch(RoleList::WAREHOUSE_ADMIN)) return false;

        return parent::viewAny($user);
    }
}
