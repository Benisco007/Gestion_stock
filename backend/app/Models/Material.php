<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'total_quantity',
        'city_id',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    // Quantité disponible = total - loué + retours
    public function getAvailableQuantityAttribute(): int
    {
        $loaned = $this->stockMovements()
            ->whereIn('type', ['sortie', 'vente'])
            ->sum('quantity');

        $returned = $this->stockMovements()
            ->where('type', 'retour')
            ->sum('quantity');

        return $this->total_quantity - $loaned + $returned;
    }
}
