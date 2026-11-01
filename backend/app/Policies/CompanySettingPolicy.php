<?php

namespace App\Policies;

use App\Models\User;

class CompanySettingPolicy
{
    public function view(User $user): bool
    {
        return true;
    }

    public function manage(User $user): bool
    {
        return $user->hasRole('proprietaire');
    }
}
