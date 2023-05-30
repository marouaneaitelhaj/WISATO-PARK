<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlOperator;
use App\User;

class ControlOperatorController extends Controller
{
    public function index()
    {
        $controlOperators = ControlOperator::all();

        return view('content.team.index', ['controlOperators' => $controlOperators]);
    }

    public function create()
    {
        $operators = User::all();

        return view('content.team.create', compact('operators'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'agent' => 'required',
            'status' => 'required',
            'remark' => 'nullable',
        ]);

        $controlOperator = new ControlOperator();
        $controlOperator->operator = $request->input('countries');
        $controlOperator->agent = $request->input('agent');
        $controlOperator->status = $request->input('status');
        $controlOperator->remark = $request->input('remark');

        $controlOperator->save();

        return redirect()->route('team.index')->with('success', 'Team added successfully.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
