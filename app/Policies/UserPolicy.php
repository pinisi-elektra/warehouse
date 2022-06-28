<?php

namespace App\Policies;

use App\Helpers\RoleList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
    }

    public function view(User $user, User $model): bool
    {
        return $user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
    }

    public function update(User $user, User $model): bool
    {
        return $user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
    }

    public function restore(User $user, User $model): bool
    {
        return $user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN);
    }
}
