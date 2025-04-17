<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $states = [
            'New South Wales',
            'Victoria',
            'Queensland',
            'Western Australia',
            'South Australia',
            'Tasmania',
            'Australian Capital Territory',
            'Northern Territory',
        ];

        foreach ($states as $state) {
            DB::table('states')->insert([
                'name' => $state,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
