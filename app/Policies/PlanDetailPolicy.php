<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PlanDetail;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanDetailPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, PlanDetail $plan)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->user_type === 'admin';
    }

    public function update(User $user, PlanDetail $plan)
    {
        return $user->user_type === 'admin';
    }

    public function delete(User $user, PlanDetail $plan)
    {
        return $user->user_type === 'admin';
    }
}
