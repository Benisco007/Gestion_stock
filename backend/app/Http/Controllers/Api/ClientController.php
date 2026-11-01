<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        // Recherche par nom
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'      => 'required|in:particulier,entreprise',
            'name'      => 'required|string|max:255',
            'ifu'       => 'nullable|string|max:100|required_if:type,entreprise',
            'phone'     => 'nullable|string|max:20',
            'whatsapp'  => 'nullable|string|max:20',
        ]);

        $client = Client::create($request->all());

        return response()->json($client, 201);
    }

    public function show(Client $client)
    {
        return response()->json($client);
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'type'      => 'sometimes|in:particulier,entreprise',
            'name'      => 'sometimes|string|max:255',
            'ifu'       => 'nullable|string|max:100',
            'phone'     => 'nullable|string|max:20',
            'whatsapp'  => 'nullable|string|max:20',
        ]);

        $client->update($request->all());

        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json(['message' => 'Client supprimé.']);
    }
}
