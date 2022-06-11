<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy extends DefaultWarehousePolicy
{
    use HandlesAuthorization;
}
