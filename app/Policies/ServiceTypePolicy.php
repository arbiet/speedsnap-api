<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ServiceType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, ServiceType $type)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->user_type === 'admin';
    }

    public function update(User $user, ServiceType $type)
    {
        return $user->user_type === 'admin';
    }

    public function delete(User $user, ServiceType $type)
    {
        return $user->user_type === 'admin';
    }
}
