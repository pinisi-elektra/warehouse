<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy extends DefaultWarehousePolicy
{
    use HandlesAuthorization;

}
