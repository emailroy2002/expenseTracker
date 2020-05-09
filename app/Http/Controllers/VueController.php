<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueController extends Controller
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
    
    
    public function index(Request $request)
    {
      
        
        $data = array('username' => $request->input('username'));
        
        return view('default', $data);
    }
}
