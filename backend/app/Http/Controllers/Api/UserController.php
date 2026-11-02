<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Liste tous les employés
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::with('roles')->get()->map(fn($u) => [
            'id'        => $u->id,
            'name'      => $u->name,
            'role'      => $u->getRoleNames()->first(),
            'is_active' => $u->is_active,
        ]);

        return response()->json($users);
    }

    // Créer un employé
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name'        => 'required|string|max:255',
            'access_code' => 'required|string|min:4',
            'role'        => 'required|in:proprietaire,employe',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'access_code' => bcrypt($request->access_code),
            'is_active'   => true,
        ]);

        $user->assignRole($request->role);

        return response()->json([
            'id'        => $user->id,
            'name'      => $user->name,
            'role'      => $user->getRoleNames()->first(),
            'is_active' => $user->is_active,
        ], 201);
    }

    // Changer le code d'accès
    public function updateCode(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'access_code' => 'required|string|min:4',
        ]);

        $user->update([
            'access_code' => bcrypt($request->access_code),
        ]);

        return response()->json(['message' => 'Code d\'accès mis à jour.']);
    }

    // Activer ou désactiver l'accès
    public function toggleActive(User $user)
    {
        $this->authorize('update', $user);

        $user->update(['is_active' => ! $user->is_active]);

        $statut = $user->is_active ? 'activé' : 'désactivé';

        return response()->json(['message' => "Accès {$statut}."]);
    }
}
