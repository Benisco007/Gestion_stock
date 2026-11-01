<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndOwnerSeeder extends Seeder
{
    public function run(): void
    {
        $proprietaire = Role::firstOrCreate(['name' => 'proprietaire', 'guard_name' => 'web']);
        $employe      = Role::firstOrCreate(['name' => 'employe',      'guard_name' => 'web']);

        $owner = User::firstOrCreate(
            ['name' => 'Propriétaire'],
            [
                'access_code' => bcrypt('1234'),
                'is_active'   => true,
            ]
        );

        $owner->assignRole($proprietaire);
    }
}
