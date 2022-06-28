<?php

namespace App\Policies;

use App\Helpers\RoleList;
use App\Models\ProductTransaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductTransactionPolicy extends DefaultWarehousePolicy
{
    public function delete(User $user, $model): bool
    {
        return false;
    }

    public function update(User $user, $model): bool
    {
        if ($user->isRoleMatch(RoleList::CENTRAL_WAREHOUSE_ADMIN)) return true;
        if ($user->isRoleMatch(RoleList::WAREHOUSE_ADMIN) && $model->created_by == $user->id) return true;

        return false;
    }
}
