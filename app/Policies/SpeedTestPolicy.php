<?php

// app/Policies/SpeedTestPolicy.php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpeedTestPolicy
{
    /**
     * Determine whether the user can perform speed tests.
     */
    public function speedtest(User $user): Response
    {
        return in_array($user->user_type, ['admin', 'user'])
            ? Response::allow()
            : Response::deny('You do not have permission to perform speed tests.');
    }
}
