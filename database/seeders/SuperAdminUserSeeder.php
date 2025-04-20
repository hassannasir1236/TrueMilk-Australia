<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperAdminUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'SuperAdmin@gmail.com'],
            [
                'name' => 'SuperAdmin',
                'email' => 'SuperAdmin@gmail.com',
                'password' => Hash::make('123456'),
                'role_id' => 1,
                'state_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
