<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Farm;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FarmSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Let's say you have 8 states with IDs 1 to 8
        $stateIds = range(1, 8);

        foreach (range(1, 50) as $i) {
            Farm::create([
                'state_id' => $faker->randomElement($stateIds),
                'name' => $faker->company . ' Farm',
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'description' => $faker->sentence(10),
                'farm_size' => $faker->numberBetween(10, 1000),
                'is_active' => $faker->boolean,
                'created_at' => $faker->dateTimeBetween('-5 years', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
