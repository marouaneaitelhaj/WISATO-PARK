<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlOperator;
use App\Models\operator_inparkzone;
use App\Models\Parkzone;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ControlOperatorController extends Controller
{





    public function index(Request $request)
    {
        $user = $request->user();

        if ($request->wantsJson()) {
            $categories = new ControlOperator();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['operatorUser', 'agentUser'];
            $join = [];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy[$column_name] = $sort;
            }

            if ($request->input('start')) {
                $offset = $request->input('start');
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['type'] = $request->input('search')['value'];
                $search['description'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            if ($user->hasRole('admin')) {
                $categories = $categories->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            } elseif ($user->hasRole('chef zone')) {
                $where['agent'] = $user->id;
                $categories = $categories->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            }

            return response()->json($categories);
        }

        return view('content.team.index');
    }





    public function create(Request $request)
    {
        $currentUser = $request->user();

        if ($currentUser->hasRole('admin')) {
            $agents = User::whereIn('id', ControlOperator::pluck('agent'))->get();
        } elseif ($currentUser->hasRole('chef zone')) {
            $agentId = $currentUser->id;
            $agents = User::whereIn('id', ControlOperator::where('agent', $agentId)->pluck('agent'))->get();
        }

        $agentOperatorList = new Collection();

        foreach ($agents as $agent) {
            $operators = ControlOperator::where('agent', $agent->id)->pluck('operator');
            $operatorDetails = User::whereIn('id', $operators)->get(['id', 'name', 'Phone', 'email', 'cin']);

            $operatorDetails = $operatorDetails->map(function ($operator) use ($agent) {
                $controlOperator = ControlOperator::where('agent', $agent->id)->where('operator', $operator->id)->first();
                $operator['id'] = $controlOperator->id;
                return $operator;
            });

            $agentOperatorList->push([
                'agent' => $agent->name,
                'operators' => $operatorDetails,
            ]);
        }

        $operators = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['gardien', 'camera']);
        })->get();

        return view('content.team.create', compact('operators', 'agentOperatorList'));
    }



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
                return redirect()->route('team.create')->with('flash_message', [
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
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'operatorId' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    
        $operatorId = $request->input('operatorId');
        $startHour = $request->input('start_date');
        $endHour = $request->input('end_date');
    
        // Update the controll_operator table with the new start_date and end_date values
        $operator = ControlOperator::findOrFail($operatorId);
        $operator->start_date = $startHour;
        $operator->end_date = $endHour;
        $operator->save();
    
        return response()->json(['message' => 'Hours updated successfully.'], 200);
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
    public function manage()
    {
        $chefId = auth()->user()->id;
        $parks = Parkzone::where('status', 1)
            ->whereHas('agent_inparkzone', function ($query) use ($chefId) {
                $query->where('agent_id', $chefId);
            })
            ->with('Quartier')
            ->with('operators')
            ->get();
        $agentOperatorList  = ControlOperator::with('operatorUser')
            ->where('agent', $chefId)
            ->with('agentUser')
            ->get();
        return view('content.team.manage', compact('parks', 'agentOperatorList'));
    }
    public function storemanage(Request $request)
    {
        $validatedData = $request->validate([
            'parkzone' => 'required',
            'operator' => 'required|array',
            'operator.*' => 'exists:users,id',
        ]);
        // delete all operator in parkzone 
        operator_inparkzone::where('parkzone_id', $request->parkzone)->delete();
        foreach ($request->operator as $operator) {
            $new = new operator_inparkzone();
            $new->parkzone_id = $request->parkzone;
            $new->operator_id = $operator;
            $new->save();
        }
        return redirect()->back()->with('flashMsg', [
            'type' => 'success',
            'msg' => 'Operator added successfully',
        ]);
    }
}
