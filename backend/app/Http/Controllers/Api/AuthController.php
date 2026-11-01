<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        // On cherche tous les utilisateurs actifs
        $user = User::where('is_active', true)
            ->get()
            ->first(fn($u) => Hash::check($request->access_code, $u->access_code));

        if (! $user) {
            return response()->json([
                'message' => 'Code d\'accès incorrect.',
            ], 401);
        }

        $token = $user->createToken('app-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'   => $user->id,
                'name' => $user->name,
                'role' => $user->getRoleNames()->first(),
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnecté.']);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id'   => $user->id,
            'name' => $user->name,
            'role' => $user->getRoleNames()->first(),
        ]);
    }
}
