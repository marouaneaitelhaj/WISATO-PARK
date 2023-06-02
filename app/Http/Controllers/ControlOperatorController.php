<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlOperator;
use App\User;
use Illuminate\Support\Collection;

class ControlOperatorController extends Controller
{
 



    public function index()
    {
        $controlOperators = ControlOperator::all();
        $agents = User::whereIn('id', $controlOperators->pluck('agent'))->get();

        $agentOperatorList = new Collection();
        foreach ($agents as $agent) {
            $operators = $controlOperators->where('agent', $agent->id)->pluck('operator');
            $operatorDetails = User::whereIn('id', $operators)->get(['name', 'Phone', 'email', 'cin']);

            $agentOperatorList->push([
                'agent' => $agent->name,
                'operators' => $operatorDetails,
            ]);
        }

        return view('content.team.index', compact('agentOperatorList'));
    }
    

    public function create()
    {

        $controlOperators = ControlOperator::all();
        $agents = User::whereIn('id', $controlOperators->pluck('agent'))->get();

        $agentOperatorList = new Collection();
        foreach ($agents as $agent) {
            $operators0 = $controlOperators->where('agent', $agent->id)->pluck('operator');
            $operatorDetails = User::whereIn('id', $operators0)->get(['name', 'Phone', 'email', 'cin']);

            $agentOperatorList->push([
                'agent' => $agent->name,
                'operators' => $operatorDetails,
            ]);
        }


        $operators = User::whereHas('roles', function ($query) {
            $query->where('name', 'gardien');
        })->get();

        return view('content.team.create', compact('operators', 'agentOperatorList'));
    }
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'operator' => 'required|array',
    //         'operator.*' => 'exists:users,id',
    //         'status' => 'required',
    //         'remark' => 'nullable',
    //     ]);

    //     $operators = $request->input('operator');
    //     $status = $request->input('status');
    //     $remark = $request->input('remark');

    //     foreach ($operators as $operator) {
    //         $controlOperator = new ControlOperator();
    //         $controlOperator->operator = $operator;
    //         $controlOperator->agent = $request->input('agent');
    //         $controlOperator->status = $status;
    //         $controlOperator->remark = $remark;
    //         $controlOperator->save();
    //     }

    //     return redirect()->route('team.index')->with('success', 'Team added successfully.');
    // }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'operator' => 'required|array',
            'operator.*' => 'exists:users,id',
            'status' => 'required',
            'remark' => 'nullable',
        ]);
    
        $operators = $request->input('operator');
        $status = $request->input('status');
        $remark = $request->input('remark');
    
        $alreadyInsertedOperators = ControlOperator::whereIn('operator', $operators)->pluck('operator')->toArray();
        $newOperators = array_diff($operators, $alreadyInsertedOperators);
    
        if (count($newOperators) > 0) {
            $insertedOperators = [];
    
            foreach ($newOperators as $operator) {
                $controlOperator = new ControlOperator();
                $controlOperator->operator = $operator;
                $controlOperator->agent = $request->input('agent');
                $controlOperator->status = $status;
                $controlOperator->remark = $remark;
                $controlOperator->save();
    
                $insertedOperators[] = User::find($operator)->name; // Fetch the operator's name
            }
    
            if (count($insertedOperators) > 0) {
                $message = 'The following operators were added successfully: ' . implode(', ', $insertedOperators);
                return redirect()->route('team.index')->with('flash_message', [
                    'type' => 'success',
                    'message' => $message,
                ]);
            }
        }
    
        $message = 'All selected operators are already inserted.';
        return redirect()->back()->with('flash_message', [
            'type' => 'error',
            'message' => $message,
        ]);
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
