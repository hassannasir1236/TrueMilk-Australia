<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farm;
use App\Models\State;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class FarmController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    // show farm page 
    public function index()
    {
        $states = State::all();
        $farms = Farm::all();
        return view('farms', compact('states', 'farms'));
    }

    // Store or update a farm
    public function saveFarm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|digits_between:10,15',
            'description' => 'nullable|string|max:1000',
            'farm_size' => 'required|numeric|min:0',
            'state_id' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['name', 'address', 'phone', 'description', 'farm_size', 'state_id']);

        $farm = $request->id ? Farm::find($request->id) : new Farm;

        if ($farm) {
            $farm->name = $data['name'];
            $farm->address = $data['address'];
            $farm->phone = $data['phone'];
            $farm->description = $data['description'];
            $farm->farm_size = $data['farm_size'];
            $farm->state_id = $data['state_id'];
            $farm->is_active = 1;
            $farm->fill($data)->save();
            return redirect()->route('farms.index')->with('success', 'Farm saved successfully.');
        }

        return redirect()->back()->with('error', 'Farm not found.');
    }
    // update the farm
    public function edit($id)
    {
        $farm = Farm::find($id);
        $states = State::all();

        if (!$farm) {
            return redirect()->route('farms.index')->with('error', 'Farm not found.');
        }

        return view('farms', compact('farm', 'states'))->with('farms', Farm::all())->with('success', 'Details Updated successfully.');
    }


    // Delete farm
    public function deleteFarm($id)
    {
        $farm = Farm::find($id);

        if (!$farm) {
            return redirect()->route('farms.index')
                ->with('error', 'Farm not found.');
        }

        $farm->delete();
        return redirect()->route('farms.index')
            ->with('success', 'Farm deleted successfully.');
    }
}
