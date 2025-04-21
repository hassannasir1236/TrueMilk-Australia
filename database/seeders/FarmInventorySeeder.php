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

        foreach ($farms as $farm) {
            // ✅ 1. Seed required data for the last week (1–3 records per farm)
            foreach (range(1, rand(1, 3)) as $i) {
                $this->createInventoryRecord($faker, $farm, $faker->dateTimeBetween('-7 days', 'now'));
            }

            // ✅ 2. Seed historical data (5–10 records per farm, -5 years range)
            foreach (range(1, rand(5, 10)) as $i) {
                $this->createInventoryRecord($faker, $farm, $faker->dateTimeBetween('-5 years', '-8 days'));
            }
        }
    }

    protected function createInventoryRecord($faker, $farm, $collectedOn)
    {
        $itemId = $faker->numberBetween(1, 5);
        $quantity = $faker->numberBetween(10, 200);
        $unit = $itemId == 1 ? 'liters' : 'kg';

        // Set price per unit
        $pricePerUnit = match ($itemId) {
            1 => 2,
            2 => 3,
            3 => 5,
            default => 3.5,
        };

        $totalPrice = $quantity * $pricePerUnit;

        FarmInventory::create([
            'state_id'      => $farm->state_id,
            'farm_id'       => $farm->id,
            'farm_item_id'  => $itemId,
            'quantity'      => $quantity,
            'unit'          => $unit,
            'total_price'   => $totalPrice,
            'collected_on'  => $collectedOn,
            'created_at'    => $faker->dateTimeBetween('-5 years', $collectedOn),
            'updated_at'    => now(),
        ]);
    }
}
