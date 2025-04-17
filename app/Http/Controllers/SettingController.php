<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
       
        return view('Setting');
    }

}
