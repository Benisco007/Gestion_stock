<?php

namespace App\Policies;

use App\Models\Material;
use App\Models\User;

class MaterialPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // propriétaire et employé
    }

    public function view(User $user, Material $material): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('proprietaire');
    }

    public function update(User $user, Material $material): bool
    {
        return $user->hasRole('proprietaire');
    }

    public function delete(User $user, Material $material): bool
    {
        return $user->hasRole('proprietaire');
    }
}
