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
        // Allow all authenticated users to perform speed tests
        return $user
            ? Response::allow()
            : Response::deny('You do not have permission to perform speed tests.');
    }
}
