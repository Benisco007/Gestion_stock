<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    // Liste tous les matériels avec stock disponible
    public function index()
    {
        $materials = Material::all()->map(function ($material) {
            return [
                'id'                 => $material->id,
                'name'               => $material->name,
                'total_quantity'     => $material->total_quantity,
                'available_quantity' => $material->available_quantity,
            ];
        });

        return response()->json($materials);
    }

    // Créer un matériel (propriétaire seulement)
    public function store(Request $request)
    {
        $this->authorize('create', Material::class);

        $request->validate([
            'name'           => 'required|string|max:255',
            'total_quantity' => 'required|integer|min:0',
        ]);

        $material = Material::create([
            'name'           => $request->name,
            'total_quantity' => $request->total_quantity,
        ]);

        return response()->json($material, 201);
    }

    // Afficher un matériel
    public function show(Material $material)
    {
        return response()->json([
            'id'                 => $material->id,
            'name'               => $material->name,
            'total_quantity'     => $material->total_quantity,
            'available_quantity' => $material->available_quantity,
        ]);
    }

    // Modifier un matériel (propriétaire seulement)
    public function update(Request $request, Material $material)
    {
        $this->authorize('update', $material);

        $request->validate([
            'name'           => 'sometimes|string|max:255',
            'total_quantity' => 'sometimes|integer|min:0',
        ]);

        $material->update($request->only('name', 'total_quantity'));

        return response()->json($material);
    }

    // Supprimer un matériel (propriétaire seulement)
    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);

        $material->delete();

        return response()->json(['message' => 'Matériel supprimé.']);
    }
}
