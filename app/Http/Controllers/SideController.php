<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sides;
use App\Models\Side_slot;

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
            $with = ['side_slots'];
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
        $sides = new Sides;
        $sides->parkzone_id = $parkzone_id;
        $sides->side = $side;
        $sides->save();

        foreach ($request->all() as $index => $value) {
            if ($index !== 'parkzone_id' && $index !== 'side') {
                for ($i = 0; $i < $value; $i++) {
                    $side_slot = new Side_slot;
                    $side_slot->side_id = $sides->id;
                    $side_slot->category_id = $index;
                    $side_slot->name = $index . '-' . $i;
                    $side_slot->save();
                }
            }
        }
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
