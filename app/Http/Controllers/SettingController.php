<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class SettingController extends Controller
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
        $roles = Role::all();
        $user = User::where('id', auth()->user()->id)->first();
        return view('Setting', compact('states', 'roles', 'user'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'role' => 'required|string',
            'state_id' => 'required|integer|min:0',
            'password' => 'nullable|string|min:8',
        ]);

        // Explicitly fetch the user model
        $user = User::findOrFail(Auth::id());

        // Build the data array for update
        $data = $request->only(['name', 'email', 'role', 'state_id']);

        // If password is filled, hash and add it
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        // Perform update using ORM
        $user->update($data);

        return redirect()->route('setting.index')->with('success', 'Profile updated successfully!');
    }
}
