<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CoverageArea;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoverageAreaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, CoverageArea $area)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->user_type === 'admin';
    }

    public function update(User $user, CoverageArea $area)
    {
        return $user->user_type === 'admin';
    }

    public function delete(User $user, CoverageArea $area)
    {
        return $user->user_type === 'admin';
    }
}
