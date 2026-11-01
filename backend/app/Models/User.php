<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'access_code',
        'is_active',
        'city_id',
    ];

    protected $hidden = [
        'access_code',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'access_code' => 'hashed',
        ];
    }
}
