<?php

namespace App\Policies;

use App\Models\ProductStock;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductStockPolicy extends DefaultWarehousePolicy
{
    public function update(User $user, $model): bool
    {
        if ($user->isRoleMatch("Super Admin")) {
            return true;
        }

        return false;
    }
}
