<?php

namespace App\Http\Controllers;

use App\Models\Parkzone;
use Exception;
use Illuminate\Http\Request;

class ParkzoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $parkzones = new Parkzone();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = [];
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
                $search['name'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $parkzones = $parkzones->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($parkzones);
        }

        return view('content.parkzones.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.parkzones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd( $request->all() );
        $validated = $request->validate([
            'name' => 'bail|required|unique:parkzones',
            'remarks' => 'bail|nullable|min:3',
            'lat' => 'bail|required',
            'lng' => 'bail|required',
            'agent_id' => 'bail|required'
        ]);
    
        $parkzone = new Parkzone();
        $parkzone->name = $request->name;
        $parkzone->remarks = $request->remarks;
        $parkzone->lat = $request->lat;
        $parkzone->agent_id = $request->agent_id;
        $parkzone->lng = $request->lng;
        $parkzone->save();
    
        return redirect()
            ->route('parkzones.index')
            ->with(['flashMsg' => ['msg' => 'Parkzone successfully added.', 'type' => 'success']]);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Parkzone  $parkzone
     * @return \Illuminate\Http\Response
     */
    public function show(Parkzone $parkzone)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parkzone  $parkzone
     * @return \Illuminate\Http\Response
     */
    public function edit(Parkzone $parkzone)
    {
        $viewData = array(
            'parkzone' => $parkzone,
        );

        return view('content.parkzones.edit')->with($viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parkzone  $parkzone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parkzone $parkzone)
    {
        $validated = $request->validate(['name' => 'bail|required|unique:parkzones,name,' . $parkzone->id,  'remarks' => 'bail|nullable|min:3']);

        $parkzone->update([
            'name'     => $validated['name'],
            'remarks'  => $validated['remarks'],
        ]);

        return redirect()
            ->route('parkzones.index')
            ->with(['flashMsg' => ['msg' => 'Parkzone successfully updated.', 'type' => 'success']]);
    }


    /**
     * Update the status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parkzone  $parkzone
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request, Parkzone $parkzone)
    {
        if ($parkzone->active_parking) {
            return back()->with(['flashMsg' => ['msg' => 'This parkzone has already been used in an active parking.', 'type' => 'warning']]);
        } else {
            if ($parkzone->status == 1) {
                $parkzone->update(['status' => 0]);
            } else {
                $parkzone->update(['status' => 1]);
            }

            return back()->with(['flashMsg' => ['msg' => 'Status successfully changed.', 'type' => 'success']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parkzone  $parkzone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parkzone $parkzone)
    {
        $parkzone->delete();
    }
}
