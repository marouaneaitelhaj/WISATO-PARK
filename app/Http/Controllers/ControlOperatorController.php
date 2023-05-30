<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlOperator;
use App\User;

class ControlOperatorController extends Controller
{
    // public function index()
    // {
    //     $controlOperators = ControlOperator::all();

    //     return view('content.team.index', ['controlOperators' => $controlOperators]);
    // }

    public function index()
{
    $controlOperators = ControlOperator::all();
    $agents = User::whereIn('id', $controlOperators->pluck('agent'))->get();
    
    $agentOperatorList = [];
    foreach ($agents as $agent) {
        $operators = $controlOperators->where('agent', $agent->id)->pluck('operator');
        $operatorNames = User::whereIn('id', $operators)->pluck('name');
        $agentOperatorList[] = [
            'agent' => $agent->name,
            'operators' => $operatorNames,
        ];
    }
    
    return view('content.team.index', compact('agentOperatorList'));
}

    public function create()
    {
        $operators = User::whereHas('roles', function ($query) {
            $query->where('name', 'gardien');
        })->get();

        return view('content.team.create', compact('operators'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'operator' => 'required|array', // Change validation rule to array
            'operator.*' => 'exists:users,id', // Validate each operator ID exists in the users table
            'status' => 'required',
            'remark' => 'nullable',
        ]);
    
        $operators = $request->input('operator');
        $status = $request->input('status');
        $remark = $request->input('remark');
    
        foreach ($operators as $operator) {
            $controlOperator = new ControlOperator();
            $controlOperator->operator = $operator;
            $controlOperator->agent = $request->input('agent');
            $controlOperator->status = $status;
            $controlOperator->remark = $remark;
            $controlOperator->save();
        }
    
        return redirect()->route('team.index')->with('success', 'Team added successfully.');
    }
    





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
