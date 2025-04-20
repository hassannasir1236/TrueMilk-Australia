<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(RoleSeeder::class);
        $this->call([
            StatesTableSeeder::class,
            FarmItemSeeder::class,
            RolesTableSeeder::class,
            SuperAdminUserSeeder::class,
            FarmSeeder::class,
            FarmInventorySeeder::class,
        ]);
    }
}
