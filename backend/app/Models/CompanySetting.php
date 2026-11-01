<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'logo_path',
        'activities',
        'phone1',
        'phone2',
        'email',
        'address',
        'rccm',
        'rccm_date',
        'ifu',
        'accent_color',
        'footer_message',
        'default_contract_text',
        'city_id',
    ];

    protected function casts(): array
    {
        return [
            'rccm_date' => 'date',
        ];
    }
}
