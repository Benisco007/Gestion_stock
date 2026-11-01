<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    // Afficher les paramètres (un seul enregistrement)
    public function show()
    {
        $settings = CompanySetting::first();

        if (! $settings) {
            return response()->json(['message' => 'Paramètres non configurés.'], 404);
        }

        return response()->json($settings);
    }

    // Créer ou mettre à jour les paramètres (propriétaire seulement)
    public function upsert(Request $request)
    {
        $this->authorize('manage', CompanySetting::class);

        $request->validate([
            'name'                  => 'required|string|max:255',
            'phone1'                => 'nullable|string|max:20',
            'phone2'                => 'nullable|string|max:20',
            'email'                 => 'nullable|email|max:255',
            'address'               => 'nullable|string|max:255',
            'rccm'                  => 'nullable|string|max:100',
            'rccm_date'             => 'nullable|date',
            'ifu'                   => 'nullable|string|max:100',
            'accent_color'          => 'nullable|string|max:7',
            'footer_message'        => 'nullable|string',
            'default_contract_text' => 'nullable|string',
            'activities'            => 'nullable|string',
        ]);

        $settings = CompanySetting::first();

        if ($settings) {
            $settings->update($request->all());
        } else {
            $settings = CompanySetting::create($request->all());
        }

        return response()->json($settings);
    }
}
