<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasUuids;

    protected $fillable = [
        'material_id',
        'type',
        'quantity',
        'document_id',
        'user_id',
        'city_id',
        'moved_at',
    ];

    protected function casts(): array
    {
        return [
            'moved_at' => 'date',
        ];
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
