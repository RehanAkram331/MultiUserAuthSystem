<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class AdminPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return true;
    }

    public function update(User $user)
    {
        return true;
    }
}