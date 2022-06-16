<?php

namespace App\Policies;

use App\Models\ProductStockHistory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductStockHistoryPolicy extends DefaultWarehousePolicy
{
    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, $model): bool
    {
        return false;
    }

    public function delete(User $user, $model): bool
    {
        return false;
    }
}
