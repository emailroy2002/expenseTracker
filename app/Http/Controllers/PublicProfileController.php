<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        if ($user = User::where('username', $username)->first()) {
            return view('public.PublicProfile');
        } else {
            return abort(404);
        }
    }

    
}
