<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;

class FloorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $limit = 10;
            $page = 1;
            $search = [];
            $where = [];
            $with = ['parkzone'];
            $orderBy = [];

            if ($request->input('length')) {
                $limit = $request->input('length');
            }

            if ($request->input('order')[0]['column'] != 0) {
                $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
                $level = $request->input('columns')[$request->input('order')[0]['column']]['level'];
                $sort = $request->input('order')[0]['dir'];
                $orderBy['parkzone.name'] = $sort;
                
            }

            if ($request->input('start')) {
                $page = floor($request->input('start') / $limit) + 1;
            }

            if ($request->input('search') && $request->input('search')['value'] != "") {
                $search['level'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $query = Floor::query()->with($with);

            if (!empty($search['level'])) {
                $query->where('level', 'LIKE', '%' . $search['level'] . '%');
            }

            $totalRecords = $query->count();

            foreach ($orderBy as $column => $direction) {
                if ($column === 'parkzone.name') {
                    $query->join('parkzones', 'floors.parkzone_id', '=', 'parkzones.id')
                        ->orderBy('parkzones.name', $direction);
                } else {
                    $query->orderBy($column, $direction);
                }
            }

            $query->limit($limit)->offset(($page - 1) * $limit);

            $data = $query->get();

            $formattedData = [
                'data' => $data,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'draw' => $request->input('draw'),
            ];

            return response()->json($formattedData);
        }

        return view('content.floor.index');
    }





    // public function index(Request  $request)
    // {

    //     if ($request->wantsJson()) {
    //         $categories = new Floor();
    //         $limit = 10;
    //         $offset = 0;
    //         $search = [];
    //         $where = [];
    //         $with = ['parkzone'];
    //         $join = [];
    //         $orderBy = [];
    
    //         if ($request->input('length')) {
    //             $limit = $request->input('length');
    //         }
    //         // dd($request->all());
    //         if ($request->input('order')[0]['column'] != 0) {
    //             $column_name = $request->input('columns')[$request->input('order')[0]['column']]['name'];
    //             $sort = $request->input('order')[0]['dir'];
    //             $orderBy[$column_name] = $sort;
    //         }

    //         if ($request->input('start')) {
    //             $offset = $request->input('start');
    //         }

    //         if ($request->input('search') && $request->input('search')['value'] != "") {
    //             $search['level'] = $request->input('search')['value'];
    //         }

    //         if ($request->input('where')) {
    //             $where = $request->input('where');
    //         }

    //         $categories = $categories->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
    //         return response()->json($categories);
    //     }
    //     return view('content.floor.index');
    // }
    


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
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'parkzone_id' => 'required',
    //         'level' => 'required|array',
    //         'shadow' => 'nullable|array',
    //         'status' => 'nullable|array',
    //     ]);
    
    //     $parkzoneId = $validated['parkzone_id'];
    //     $levels = $validated['level'];
    //     $shadows = $validated['shadow'] ?? [];
    //     $statuses = $validated['status'] ?? [];
    
    //     foreach ($levels as $index => $level) {
    //         $floor = new Floor();
    //         $floor->parkzone_id = $parkzoneId;
    //         $floor->level = $level;
    //         $floor->shadow = isset($shadows[$index]) ? $shadows[$index] : null;
    //         $floor->status = isset($statuses[$index]) ? $statuses[$index] : null;
    //         $floor->save();
    //     }
    
    //     return response()->json(['message' => 'Floors created successfully']);
    // }



//     public function store(Request $request)
// {
//     $validated = $request->validate([
//         'parkzone_id' => 'required',
//         'level' => 'required|array',
//         'shadow' => 'nullable|array',
//         'status' => 'nullable|array',
//         'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:2048', // Updated validation rule for the image field

//     ]);

//     $parkzoneId = $validated['parkzone_id'];
//     $levels = $validated['level'];
//     $shadows = $validated['shadow'] ?? [];
//     $statuses = $validated['status'] ?? [];

    

//     foreach ($levels as $index => $level) {
//         // Check if the floor already exists
//         $existingFloor = Floor::where('parkzone_id', $parkzoneId)
//             ->where('level', $level)
//             ->first();

//         if ($existingFloor) {
//             return response()->json(['message' => 'The floor already inserted'], 422);
//         }

//         $floor = new Floor();
//         $floor->parkzone_id = $parkzoneId;
//         $floor->level = $level;
//         $floor->shadow = isset($shadows[$index]) ? $shadows[$index] : null;
//         $floor->status = isset($statuses[$index]) ? $statuses[$index] : null;
//         $floor->save();
//     }

//     return response()->json(['message' => 'The floor has been created successfully.']);
// }


public function store(Request $request)
{
    $validated = $request->validate([
        'parkzone_id' => 'required',
        'level' => 'required|array',
        'shadow' => 'nullable|array',
        'status' => 'nullable|array',
        'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:2048', // Updated validation rule for the image field
    ]);

    $parkzoneId = $validated['parkzone_id'];
    $levels = $validated['level'];
    $shadows = $validated['shadow'] ?? [];
    $statuses = $validated['status'] ?? [];

    foreach ($levels as $index => $level) {
        // Check if the floor already exists
        $existingFloor = Floor::where('parkzone_id', $parkzoneId)
            ->where('level', $level)
            ->first();

        if ($existingFloor) {
            return response()->json(['message' => 'The floor already exists.'], 422);
        }

        $floor = new Floor();
        $floor->parkzone_id = $parkzoneId;
        $floor->level = $level;
        $floor->shadow = isset($shadows[$index]) ? $shadows[$index] : null;
        $floor->status = isset($statuses[$index]) ? $statuses[$index] : null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('floor', 'public');
            $floor->image = $imagePath;
        }

        $floor->save();
    }

    return response()->json(['message' => 'The floor has been created successfully.']);
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
