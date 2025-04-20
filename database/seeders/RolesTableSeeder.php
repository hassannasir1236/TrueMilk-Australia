<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ this line is needed!

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = ['admin', 'farmer', 'manager'];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
