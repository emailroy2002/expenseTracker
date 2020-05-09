<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Models\Experience;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Experience::create([
            'user_id' => $request->user_id,
            'position' => $request->position,
            'company' => $request->company,
            'description' => $request->description,
            'yearStarted' => $request->yearStarted,
            'yearEnded' => $request->yearEnded
        ]);
        return Response()->json([
            "success" => true,
            "experience" => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($request->user_id)->experience->find($request->experience['id']);
        $user->company = $request->experience['company'];
        $user->position = $request->experience['position'];
        $user->description = $request->experience['description'];
        $user->yearStarted = $request->experience['yearStarted'];
        $user->yearEnded = $request->experience['yearEnded'];
        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = User::find($request->user_id)->experience->find($request->experience['id'])->delete();
    }
}
