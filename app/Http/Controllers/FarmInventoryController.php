<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Farm;
use App\Models\FarmItem;
use App\Models\FarmInventory;

class FarmInventoryController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function index()
    {
        $states = State::all();
        $items = FarmItem::all();
        $inventories = FarmInventory::with(['state', 'farm', 'item'])->latest()->get();

        $selectedStateId = old('state_id');
        $farms = [];

        if ($selectedStateId) {
            $farms = Farm::where('state_id', $selectedStateId)->get();
        }

        return view('farms-inventory', compact('states', 'items', 'farms', 'inventories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'farm_id' => 'required|exists:farms,id',
            'farm_item_id' => 'required|exists:farm_items,id',
            'quantity' => 'required|numeric|min:0.01',
            'unit' => 'required|in:liters,kg',
            'collected_on' => 'required|date',
            'notes' => 'nullable|string',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        $data = $request->only(['state_id', 'farm_id', 'farm_item_id', 'quantity', 'unit', 'collected_on', 'notes']);
        $unitPrice = $request->input('unit_price', 0);
        $data['total_price'] = $unitPrice * $data['quantity'];

        if ($request->filled('id')) {

            // Update
            $inventory = FarmInventory::findOrFail($request->id);
            $inventory->update($data);
            return redirect()->route('farm-inventory.index')->with('success', 'Inventory updated successfully.');
        } else {
            // Create
            FarmInventory::create($data);
            return redirect()->route('farm-inventory.index')->with('success', 'Inventory added successfully.');
        }
    }

    public function edit($id)
    {
        $inventory = FarmInventory::with('farm.state')->findOrFail($id);
        $states = State::all();
        $items = FarmItem::all();

        // Fetch farms for selected state to prefill dropdown
        $farms = Farm::where('state_id', $inventory->farm->state_id)->get();

        $inventories = FarmInventory::with('farm.state', 'item')->orderBy('collected_on', 'desc')->get();

        return view('farms-inventory', compact('states', 'items', 'farms', 'inventory', 'inventories'));
    }

    public function destroy($id)
    {
        $inventory = FarmInventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('farm-inventory.index')->with('success', 'Inventory deleted successfully.');
    }

    // AJAX helper
    public function getFarmsByState($state_id)
    {
        $farms = Farm::where('state_id', $state_id)->get();
        return response()->json($farms);
    }

}
