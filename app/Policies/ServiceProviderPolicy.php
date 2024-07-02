<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ServiceProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceProviderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, ServiceProvider $provider)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->user_type === 'admin';
    }

    public function update(User $user, ServiceProvider $provider)
    {
        return $user->user_type === 'admin';
    }

    public function delete(User $user, ServiceProvider $provider)
    {
        return $user->user_type === 'admin';
    }
}
