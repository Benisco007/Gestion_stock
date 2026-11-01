<?php

namespace App\Services;

use App\Models\Material;
use App\Models\StockMovement;

class StockService
{
    /**
     * Vérifier si une quantité est disponible pour un matériel.
     */
    public function verifierDisponibilite(string $materialId, int $quantite): bool
    {
        $material = Material::findOrFail($materialId);
        return $material->available_quantity >= $quantite;
    }

    /**
     * Sortir des matériels (création d'une facture).
     * Lève une exception si stock insuffisant.
     */
    public function sortir(string $materialId, int $quantite, string $documentId, string $userId): StockMovement
    {
        $material = Material::findOrFail($materialId);

        if ($material->available_quantity < $quantite) {
            throw new \Exception(
                "Il ne reste que {$material->available_quantity} {$material->name} disponible(s)."
            );
        }

        return StockMovement::create([
            'material_id' => $materialId,
            'type'        => 'sortie',
            'quantity'    => $quantite,
            'document_id' => $documentId,
            'user_id'     => $userId,
            'moved_at'    => now(),
        ]);
    }

    /**
     * Retourner des matériels (retour partiel ou total).
     */
    public function retourner(string $materialId, int $quantite, string $documentId, string $userId): StockMovement
    {
        return StockMovement::create([
            'material_id' => $materialId,
            'type'        => 'retour',
            'quantity'    => $quantite,
            'document_id' => $documentId,
            'user_id'     => $userId,
            'moved_at'    => now(),
        ]);
    }

    /**
     * Vendre des matériels (sortie définitive, pas de retour attendu).
     */
    public function vendre(string $materialId, int $quantite, string $documentId, string $userId): StockMovement
    {
        $material = Material::findOrFail($materialId);

        if ($material->available_quantity < $quantite) {
            throw new \Exception(
                "Il ne reste que {$material->available_quantity} {$material->name} disponible(s)."
            );
        }

        return StockMovement::create([
            'material_id' => $materialId,
            'type'        => 'vente',
            'quantity'    => $quantite,
            'document_id' => $documentId,
            'user_id'     => $userId,
            'moved_at'    => now(),
        ]);
    }

    /**
     * Ajustement manuel du stock par le propriétaire.
     */
    public function ajuster(string $materialId, int $quantite, string $userId): StockMovement
    {
        return StockMovement::create([
            'material_id' => $materialId,
            'type'        => 'ajustement',
            'quantity'    => $quantite,
            'user_id'     => $userId,
            'moved_at'    => now(),
        ]);
    }

    /**
     * Quantité disponible d'un matériel.
     */
    public function disponible(string $materialId): int
    {
        $material = Material::findOrFail($materialId);
        return $material->available_quantity;
    }
}
