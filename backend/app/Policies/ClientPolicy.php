<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Client $client): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true; // propriétaire et employé
    }

    public function update(User $user, Client $client): bool
    {
        return true; // propriétaire et employé
    }

    public function delete(User $user, Client $client): bool
    {
        return $user->hasRole('proprietaire');
    }
}
