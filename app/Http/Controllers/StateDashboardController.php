<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Farm;
use App\Models\FarmInventory;
class StateDashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('role:admin,super-admin');
    }
    public function index($stateId = null)
    {
        return view('state-dashboard', compact('stateId'));
    }
}
