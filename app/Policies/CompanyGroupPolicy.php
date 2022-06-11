<?php

namespace App\Policies;

use App\Models\CompanyGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyGroupPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, CompanyGroup $companyGroup): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, CompanyGroup $companyGroup): bool
    {
        //
    }

    public function delete(User $user, CompanyGroup $companyGroup): bool
    {
        //
    }

    public function restore(User $user, CompanyGroup $companyGroup): bool
    {
        //
    }

    public function forceDelete(User $user, CompanyGroup $companyGroup): bool
    {
        //
    }
}
