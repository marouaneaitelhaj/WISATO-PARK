<?php

namespace App\Http\Controllers;

use App\Models\Parkzone;
use Illuminate\Http\Request;
use App\Models\Sides;
use App\Models\Category;
use App\Models\Side_slot;
use App\Models\Side_slot_number;

class SideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $sides = new Sides();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['side_slots', 'parkzone', 'side_slot_numbers'];
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

            $sides = $sides->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($sides);
        }
        return view('content.side.list');
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
        $parkzone_id = $request->parkzone_id;
        $side = $request->side;
        $check = Sides::where('parkzone_id', $parkzone_id)->where('side', $side)->first();
        if ($check != null) {
            $parkzone = Parkzone::find($parkzone_id)->first();
            if ($parkzone->in_use == 0) {
                $check->delete();
            } else {
                $message = 'Side already exist, and you can not delete it because the parkzone is in use';
                return response()->json($message, 404);
            }
        }
        $sides = new Sides;
        $sides->parkzone_id = $parkzone_id;
        $sides->side = $side;
        $sides->save();
        foreach ($request->all() as $index => $value) {
            if ($index !== 'parkzone_id' && $index !== 'side') {
                $check = Side_slot_number::where('side_id', $sides->id)->where('category_id', $index)->first();
                if ($check != null) {
                    $check->delete();
                }
                $Side_slot_number = new Side_slot_number;
                $Side_slot_number->side_id = $sides->id;
                if ($value == null) {
                    $value = 0;
                }
                $Side_slot_number->slot_number = $value;
                $Side_slot_number->category_id = $index;
                $Side_slot_number->save();
                for ($i = 0; $i < $value; $i++) {
                    $side_slot = new Side_slot;
                    $side_slot->side_id = $sides->id;
                    $side_slot->category_id = $index;
                    $category = Category::find($index)->first();
                    $side_slot->name = strtok($category->type, ' ') . '-' . count(Side_slot::where('category_id', $index)->get()) + 1;
                    $side_slot->save();
                }
            }
        }
        $message = 'Side is created';
        return response()->json($message, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $side_slot = Side_slot::where('side_id', $id)->get();
        return response()->json($side_slot, 200);
    }
    public function showSide($id)
    {
        $side = Sides::where('parkzone_id', $id)->with('side_slot_numbers')->first();
        return response()->json($side, 200);
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
        Sides::find($id)->first()->delete();
    }
    public function toogleactive(Request $request)
    {
        $sides =  Sides::where('side', $request->side)->where('parkzone_id', $request->parkzoneId)->first();
        if ($sides != null) {
            if ($sides->is_active == 1) {
                $sides->is_active = 0;
                $sides->save();
                $message = 'Side is deactivated';
                return response()->json($message, 200);
            } else {
                $sides->is_active = 1;
                $sides->save();
                $message = 'Side is activated';
                return response()->json($message, 200);
            }
        } else {
            $message = 'Side not found';
            return response()->json($message, 404);
        }
    }
    public function check_if_side_is_activ(Request $request)
    {
        $side = Sides::where('side', $request->side)->where('parkzone_id', $request->parkzoneId)->first();
        if ($side != null) {
            $data = [];
            $data['side'] = $side;
            $data['side_slot'] = Side_slot_number::where('side_id', $side->id)->get();
            if ($side->is_active == 1) {
                $message = 'active';
                return response()->json(['message' => $message, 'data' => $data], 200);
            } else {
                $message = 'notactive';
                return response()->json(['message' => $message, 'data' => $data], 200);
            }
        } else {
            $message = 'notfound';
            return response()->json($message, 404);
        }
    }
    public function toogleslotside(Request $request)
    {
        $side_slot = Side_slot::where('id', $request->id)->first();
        if ($side_slot != null) {
            if ($side_slot->is_active == 1) {
                $side_slot->is_active = 0;
                $side_slot->save();
                $message = 'Slot is deactivated';
                return response()->json($message, 200);
            } else {
                $side_slot->is_active = 1;
                $side_slot->save();
                $message = 'Slot is activated';
                return response()->json($message, 200);
            }
        } else {
            $message = 'Slot not found';
            return response()->json($message, 404);
        }
    }
}
