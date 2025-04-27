<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class OrderPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user)
    {
        // check if user is admin
        return $user->role === UserRole::ADMIN;
    }

}
