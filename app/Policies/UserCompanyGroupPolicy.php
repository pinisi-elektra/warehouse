<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCompanyGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserCompanyGroupPolicy
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

    public function view(User $user, UserCompanyGroup $userCompanyGroup): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, UserCompanyGroup $userCompanyGroup): bool
    {
        //
    }

    public function delete(User $user, UserCompanyGroup $userCompanyGroup): bool
    {
        //
    }

    public function restore(User $user, UserCompanyGroup $userCompanyGroup): bool
    {
        //
    }

    public function forceDelete(User $user, UserCompanyGroup $userCompanyGroup): bool
    {
        //
    }
}
