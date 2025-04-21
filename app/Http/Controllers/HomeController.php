<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FarmInventory;
use App\Models\FarmItem;
use App\Models\Farm;
use Carbon\Carbon;
use App\Models\State;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $states = State::all();
        $milkItem = FarmItem::where('name', 'milk')->first();
        $cheeseItem = FarmItem::where('name', 'Cheese')->first();

        $totalMilk = 0;
        $totalCheese = 0;
        // collect totoal milk in liters
        if ($milkItem) {
            $totalMilk = FarmInventory::where('farm_item_id', $milkItem->id)
                ->where('unit', 'liters')
                ->sum('quantity');
        }
        // collect total chesse in kg
        if ($cheeseItem) {
            $totalCheese = FarmInventory::where('farm_item_id', $cheeseItem->id)
                ->where('unit', 'kg')
                ->sum('quantity');
        }
        // collect total farms
        $totalFarms = Farm::count('id');
        // get the total price of inventory
        $totalPrice = FarmInventory::sum('total_price');

        // ge the last month to this month arrow up/down code

        $thisMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        $thisMonthMilk = FarmInventory::where('farm_item_id', $milkItem->id)
            ->whereMonth('collected_on', $thisMonth->month)
            ->whereYear('collected_on', $thisMonth->year)
            ->sum('quantity');
        $lastMonthMilk = FarmInventory::where('farm_item_id', $milkItem->id)
            ->whereMonth('collected_on', $lastMonth->month)
            ->whereYear('collected_on', $lastMonth->year)
            ->sum('quantity');

        if ($lastMonthMilk > 0) {
            $rawPercentage = (($thisMonthMilk - $lastMonthMilk) / $lastMonthMilk) * 100;
        } else {
            $rawPercentage = $thisMonthMilk > 0 ? 100 : 0;
        }

        // ✅ Cap percentage between 0 and 100
        $milkPercentage = min(100, max(0, round($rawPercentage, 1)));

        // Cheese
        $thisMonthCheese = FarmInventory::where('farm_item_id', $cheeseItem->id)
            ->whereMonth('collected_on', $thisMonth->month)
            ->whereYear('collected_on', $thisMonth->year)
            ->sum('quantity');

        $lastMonthCheese = FarmInventory::where('farm_item_id', $cheeseItem->id)
            ->whereMonth('collected_on', $lastMonth->month)
            ->whereYear('collected_on', $lastMonth->year)
            ->sum('quantity');

        $cheesePercentage = $lastMonthCheese > 0
            ? (($thisMonthCheese - $lastMonthCheese) / $lastMonthCheese) * 100
            : ($thisMonthCheese > 0 ? 100 : 0);
        // ✅ Cap percentage between 0 and 100
        $cheesePercentage = min(100, max(0, round($cheesePercentage, 1)));
        
        // Farms
        $thisMonthFarms = Farm::whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->count();

        $lastMonthFarms = Farm::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $farmPercentage = $lastMonthFarms > 0
            ? (($thisMonthFarms - $lastMonthFarms) / $lastMonthFarms) * 100
            : ($thisMonthFarms > 0 ? 100 : 0);

        // Total Price
        $thisMonthPrice = FarmInventory::whereMonth('collected_on', $thisMonth->month)
            ->whereYear('collected_on', $thisMonth->year)
            ->sum('total_price');

        $lastMonthPrice = FarmInventory::whereMonth('collected_on', $lastMonth->month)
            ->whereYear('collected_on', $lastMonth->year)
            ->sum('total_price');

        $pricePercentage = $lastMonthPrice > 0
            ? (($thisMonthPrice - $lastMonthPrice) / $lastMonthPrice) * 100
            : ($thisMonthPrice > 0 ? 100 : 0);

        // ✅ Cap percentage between 0 and 100
        $pricePercentage = min(100, max(0, round($pricePercentage, 1)));
                

        // Milk Collection By Region/province

        $milkByProvince = [];
        $cheeseByProvince = [];
        $monthlyProduction = [
            'months' => [],
            'milk' => [],
            'cheese' => [],
        ];

        foreach ($states as $state) {
            $milkByProvince[$state->name] = [
                'name' => $state->name,
                'milkCollection' => FarmInventory::where('state_id', $state->id)
                    ->where('farm_item_id', $milkItem->id)
                    ->where('unit', 'liters')
                    ->sum('quantity')
            ];

            $cheeseByProvince[$state->name] = [
                'name' => $state->name,
                'cheeseCollection' => FarmInventory::where('farm_item_id', $cheeseItem->id)
                    ->where('state_id', $state->id)
                    ->where('unit', 'kg')
                    ->sum('quantity')
            ];
        }
        // Monthly production for last 6 months (example)
        $months = now()->subMonths(5)->monthsUntil(now());
        foreach ($months as $month) {
            $label = $month->format('M Y');
            $monthlyProduction['months'][] = $label;

            $monthlyProduction['milk'][] = FarmInventory::where('farm_item_id', $milkItem->id)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('quantity');

            $monthlyProduction['cheese'][] = FarmInventory::where('farm_item_id', $cheeseItem->id)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('quantity');
        }
        return view('home', compact(
            'totalMilk',
            'totalCheese',
            'totalFarms',
            'totalPrice',
            'thisMonthMilk',
            'lastMonthMilk',
            'milkPercentage',
            'thisMonthCheese',
            'lastMonthCheese',
            'cheesePercentage',
            'thisMonthFarms',
            'lastMonthFarms',
            'farmPercentage',
            'thisMonthPrice',
            'lastMonthPrice',
            'pricePercentage',
            'milkByProvince',
            'cheeseByProvince',
            'monthlyProduction'
        ));
    }
}
