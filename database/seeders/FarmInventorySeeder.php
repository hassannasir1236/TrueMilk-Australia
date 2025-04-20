<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FarmInventory;
use App\Models\Farm;
use Faker\Factory as Faker;

class FarmInventorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $farms = Farm::all();

        // Loop through existing farms and create inventories
        foreach ($farms as $farm) {
            // Let's add 5-10 entries per farm
            foreach (range(1, rand(5, 10)) as $i) {
                $itemId = $faker->numberBetween(1, 5); // Assuming you have 5 farm_item types (1 = milk, 2 = cheese, etc.)
                $quantity = $faker->numberBetween(10, 200); // in liters/kg
                if($itemId == 1){
                    $unit = 'liters';
                }else{
                    $unit = 'kg';
                }

                // Set price per item
                switch ($itemId) {
                    case 1: $pricePerUnit = 2; break; // Milk
                    case 2: $pricePerUnit = 3; break; // Cheese
                    case 3: $pricePerUnit = 5; break; // Yogurt
                    default: $pricePerUnit = 3.5; break;
                }

                $totalPrice = $quantity * $pricePerUnit;

                FarmInventory::create([
                    'state_id' => $farm->state_id,
                    'farm_id' => $farm->id,
                    'farm_item_id' => $itemId,
                    'quantity' => $quantity,
                    'unit' => $unit,
                    'total_price' => $totalPrice,
                    'collected_on' => $faker->dateTimeBetween('-2 years', 'now'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
