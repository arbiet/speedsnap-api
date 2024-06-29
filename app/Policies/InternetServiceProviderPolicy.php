<?php

namespace App\Policies;

use App\Models\InternetServiceProvider;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InternetServiceProviderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        // Allow any authenticated user to view any InternetServiceProvider records
        return Response::allow();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InternetServiceProvider $internetServiceProvider): Response
    {
        // Allow any authenticated user to view a specific InternetServiceProvider record
        return Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        // Allow any authenticated user to create a new InternetServiceProvider record
        return Response::allow();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InternetServiceProvider $internetServiceProvider): Response
    {
        // Only allow the owner of the InternetServiceProvider record to update it
        return $user->id === $internetServiceProvider->user_id
            ? Response::allow()
            : Response::deny('You do not own this Internet Service Provider.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InternetServiceProvider $internetServiceProvider): Response
    {
        // Only allow the owner of the InternetServiceProvider record to delete it
        return $user->id === $internetServiceProvider->user_id
            ? Response::allow()
            : Response::deny('You do not own this Internet Service Provider.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InternetServiceProvider $internetServiceProvider): Response
    {
        // Only allow the owner of the InternetServiceProvider record to restore it
        return $user->id === $internetServiceProvider->user_id
            ? Response::allow()
            : Response::deny('You do not own this Internet Service Provider.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InternetServiceProvider $internetServiceProvider): Response
    {
        // Only allow the owner of the InternetServiceProvider record to permanently delete it
        return $user->id === $internetServiceProvider->user_id
            ? Response::allow()
            : Response::deny('You do not own this Internet Service Provider.');
    }
}
