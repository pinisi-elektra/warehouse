<?php

namespace App\Policies;

use App\Helpers\RoleList;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DefaultWarehousePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        if ($user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN)) return true;

        return false;
    }

    public function update(User $user, $model): bool
    {
        if ($user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN)) return true;

        return false;
    }

    public function delete(User $user, $model): bool
    {
        return false;
    }

    public function restore(User $user, $model): bool
    {
        if ($user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN)) return true;

        return false;
    }

    public function forceDelete(User $user, $model): bool
    {
        return false;
    }
}
