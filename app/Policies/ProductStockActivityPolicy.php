<?php

namespace App\Policies;

use App\Models\ProductStockActivity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductStockActivityPolicy extends DefaultWarehousePolicy
{
    public function update(User $user, $model): bool
    {
        return false;
    }

    public function delete(User $user, $model): bool
    {
        return false;
    }
}
