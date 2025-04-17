<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FarmItem;
class FarmItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Milk'],
            ['name' => 'Cheese'],
            ['name' => 'Cream'],
            ['name' => 'Yogurt'],
            ['name' => 'Butter'],
        ];

        foreach ($items as $item) {
            FarmItem::firstOrCreate($item); // avoids duplicates
        }
    }
}
