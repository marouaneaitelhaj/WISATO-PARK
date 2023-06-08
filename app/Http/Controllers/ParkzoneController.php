<?php

namespace App\Http\Controllers;

use App\Models\Parkzone;
use App\Models\Category;
use App\Models\Quartier;
use App\Models\CategoryWiseParkzoneSlot;
use App\Models\Floor;



use App\Models\Cities;
use Exception;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\App;

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
            $with = ['agents', 'Quartier'];
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
        $categories = Category::get();
        return view('content.parkzones.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'bail|required|unique:parkzones',
            'type' => 'bail|required',
            'mode' => 'bail|required',
            'remarks' => 'bail|nullable|min:3',
            'lat' => 'bail|required',
            // 'category' => 'bail|required|array', // Ensure category is an array
            'lng' => 'bail|required',
            'agent_id' => 'bail|required|array', // Ensure agent_id is an array
            'agent_id.*' => 'exists:users,id',
            'quartier_id' => 'required',
        ]);


        $parkzone = new Parkzone();
        $parkzone->name = $request->name;
        $parkzone->type = $request->type;
        $parkzone->mode = $request->mode;
        $parkzone->remarks = $request->remarks;
        $parkzone->lat = $request->lat;
        $parkzone->lng = $request->lng;
        $parkzone->quartier_id = $request->quartier_id;
        $parkzone->save();



        // Attach agent_id values to the parkzone using the pivot table
        $parkzone->agents()->attach($request->agent_id);
        // dd($request->all());

        return redirect()
            ->route('parkzones.index')
            ->with(['flashMsg' => ['msg' => 'Parkzone successfully added.', 'type' => 'success']]);
    }

    // public function store2(Request $request)
    // {
    //     $validated = $request->validate([
    //         'parkzone_id' => 'required',
    //         'levelUp' => 'required',
    //         'levelDown' => 'required',
    //     ]);
    //     $floor = new Floor();
    //     $floor->parkzone_id = $validated['parkzone_id'];
    //     $floor->levelUp = $validated['levelUp'];
    //     $floor->levelDown = $validated['levelDown'];
    //     $floor->save();
        
    //     return response()->json(['message' => 'Floor created successfully']);
    // }
    



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
        // dd($parkzone);
        $viewData = array(
            'parkzone' => $parkzone,
            'quartier' => Quartier::find($parkzone->quartier_id),
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
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'bail|required|unique:parkzones,name,' . $parkzone->id,
            'remarks' => 'bail|nullable|min:3',
            'mode' => 'bail|required',
            'lat' => 'bail|required',
            'lng' => 'bail|required',
            'type' => 'bail|required',
            'quartier_id' => 'required',
            'agent_id' => 'bail|required|array', // Ensure agent_id is an array
            'agent_id.*' => 'exists:users,id',


        ]);

        $parkzone->agents()->sync($request->agent_id);

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
    public function dashboard()
    {
        $chefId = auth()->user()->id;
        $data = Parkzone::where('status', 1)
            ->whereHas('agent_inparkzone', function ($query) use ($chefId) {
                $query->where('agent_id', $chefId);
            })
            ->with('Quartier')
            ->get();
        $quartiers = Quartier::all();
        $categories = Category::all();
        return view('content.parkzones.dashboard', compact('categories', 'data'));
    }
}
