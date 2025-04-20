<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Farm;
use App\Models\FarmInventory;
use App\Models\FarmItem;
use Carbon\Carbon;
class StateDashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('role:admin,super-admin');
    }
    public function index($stateId = null)
    {
        $milkItem = FarmItem::where('name', 'milk')->first();
        $cheeseItem = FarmItem::where('name', 'Cheese')->first();

        // get the state name by stateid
        $state = State::find($stateId);

        $totalMilk = 0;
        $totalCheese = 0;
        // collect totoal milk in liters
        if ($milkItem) {
            $totalMilk = FarmInventory::where('state_id', $stateId)->where('farm_item_id', $milkItem->id)
                ->where('unit', 'liters')
                ->sum('quantity');
        }
        // collect total chesse in kg
        if ($cheeseItem) {
            $totalCheese = FarmInventory::where('state_id', $stateId)->where('farm_item_id', $cheeseItem->id)
                ->where('unit', 'kg')
                ->sum('quantity');
        }
        // collect total farms
        $totalFarms = Farm::where('state_id', $stateId)->count('id');
        // get the total price of inventory
        $totalPrice = FarmInventory::where('state_id', $stateId)->sum('total_price');


        // ge the last month to this month arrow

        $thisMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Milk
        $thisMonthMilk = FarmInventory::where('state_id', $stateId)->where('farm_item_id', $milkItem->id)
            ->whereMonth('collected_on', $thisMonth->month)
            ->whereYear('collected_on', $thisMonth->year)
            ->sum('quantity');

        $lastMonthMilk = FarmInventory::where('state_id', $stateId)->where('farm_item_id', $milkItem->id)
            ->whereMonth('collected_on', $lastMonth->month)
            ->whereYear('collected_on', $lastMonth->year)
            ->sum('quantity');

        $milkPercentage = $lastMonthMilk > 0
            ? (($thisMonthMilk - $lastMonthMilk) / $lastMonthMilk) * 100
            : ($thisMonthMilk > 0 ? 100 : 0);

        // Cheese
        $thisMonthCheese = FarmInventory::where('state_id', $stateId)->where('farm_item_id', $cheeseItem->id)
            ->whereMonth('collected_on', $thisMonth->month)
            ->whereYear('collected_on', $thisMonth->year)
            ->sum('quantity');

        $lastMonthCheese = FarmInventory::where('state_id', $stateId)->where('farm_item_id', $cheeseItem->id)
            ->whereMonth('collected_on', $lastMonth->month)
            ->whereYear('collected_on', $lastMonth->year)
            ->sum('quantity');

        $cheesePercentage = $lastMonthCheese > 0
            ? (($thisMonthCheese - $lastMonthCheese) / $lastMonthCheese) * 100
            : ($thisMonthCheese > 0 ? 100 : 0);

        // Farms
        $thisMonthFarms = Farm::where('state_id', $stateId)->whereMonth('created_at', $thisMonth->month)
            ->whereYear('created_at', $thisMonth->year)
            ->count();

        $lastMonthFarms = Farm::where('state_id', $stateId)->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();

        $farmPercentage = $lastMonthFarms > 0
            ? (($thisMonthFarms - $lastMonthFarms) / $lastMonthFarms) * 100
            : ($thisMonthFarms > 0 ? 100 : 0);

        // Total Price
        $thisMonthPrice = FarmInventory::where('state_id', $stateId)->whereMonth('collected_on', $thisMonth->month)
            ->whereYear('collected_on', $thisMonth->year)
            ->sum('total_price');

        $lastMonthPrice = FarmInventory::where('state_id', $stateId)->whereMonth('collected_on', $lastMonth->month)
            ->whereYear('collected_on', $lastMonth->year)
            ->sum('total_price');

        $pricePercentage = $lastMonthPrice > 0
            ? (($thisMonthPrice - $lastMonthPrice) / $lastMonthPrice) * 100
            : ($thisMonthPrice > 0 ? 100 : 0);


        // Suppiler/FarmInventory details
        $FarmInventoryData = FarmInventory::where('state_id', $stateId)
            ->with(['farm', 'item', 'state'])
            ->orderBy('collected_on', 'desc')
            ->get();


        // charts line of code 
        $today = Carbon::today();
        $lastWeek = $today->copy()->subDays(6); // Last 7 days including today

        // 1. Daily Milk Collection (last 7 days)
        $dailyMilkData = FarmInventory::selectRaw('DATE(collected_on) as date, SUM(quantity) as total')
            ->where('state_id', $stateId)
            ->where('farm_item_id', 1) // assuming 1 = milk
            ->where('unit', 'liters')
            ->whereBetween('collected_on', [$lastWeek, $today])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

        $dailyLabels = [];
        $dailyTotals = [];
        for ($i = 0; $i <= 6; $i++) {
            $date = $lastWeek->copy()->addDays($i)->format('Y-m-d');
            $dailyLabels[] = $date;
            $dailyTotals[] = $dailyMilkData[$date] ?? 0;
        }

        $dailyMilk = [
            'labels' => $dailyLabels,
            'data' => $dailyTotals
        ];

        // 2. Product Distribution by farm_item_id
        $productData = FarmInventory::select('farm_item_id')
            ->selectRaw('SUM(quantity) as total')
            ->where('state_id', $stateId)
            ->groupBy('farm_item_id')
            ->get();

        $productLabels = [];
        $productTotals = [];

        foreach ($productData as $row) {
            $item = FarmItem::find($row->farm_item_id);
            $productLabels[] = $item ? $item->name : 'Unknown';
            $productTotals[] = $row->total;
        }

        $productDistribution = [
            'labels' => $productLabels,
            'data' => $productTotals
        ];
        return view('state-dashboard', compact(
            'stateId',
            'state',
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
            'FarmInventoryData',
            'dailyMilk',
            'productDistribution'
        ));
    }
}
