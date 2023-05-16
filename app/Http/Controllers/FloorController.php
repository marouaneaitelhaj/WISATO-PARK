<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use Exception;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $floors = Floor::all();
        return view('content.floors.list', compact('floors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.floors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate(['name' => 'bail|required|unique:floors', 'remarks' => 'bail|nullable|min:3']);

        $floor = Floor::create([
            'name'     => $validated['name'],
            'remarks'     => $validated['remarks'],
        ]);

        return redirect()
            ->route('floors.index')
            ->with(['flashMsg' => ['msg' => 'Floor successfully added.', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function show(Floor $floor)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function edit(Floor $floor)
    {
        $viewData = array(
            'floor' => $floor,
        );

        return view('content.floors.edit')->with($viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Floor $floor)
    {
        $validated = $request->validate(['name' => 'bail|required|unique:floors,name,' . $floor->id,  'remarks' => 'bail|nullable|min:3']);

        $floor->update([
            'name'     => $validated['name'],
            'remarks'  => $validated['remarks'],
        ]);

        return redirect()
            ->route('floors.index')
            ->with(['flashMsg' => ['msg' => 'Floor successfully updated.', 'type' => 'success']]);
    }
   
   
    /**
     * Update the status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request, Floor $floor)
    {
        if ($floor->active_parking) {
            return back()->with(['flashMsg' => ['msg' => 'This floor has already been used in an active parking.', 'type' => 'warning']]);
        }
        else{
            if($floor->status == 1){
                $floor->update(['status' => 0]);
            }
            else{
                $floor->update(['status' => 1]);
            }

            return back()->with(['flashMsg' => ['msg' => 'Status successfully changed.', 'type' => 'success']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Floor $floor)
    {
       $floor->delete();
    }
}
