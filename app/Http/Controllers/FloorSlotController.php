<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FloorSlot;

class FloorSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    $categories = $request->input('categories', []);
    $floors = [];

    $startNumber = 1;

    foreach ($categories as $category) {
        $floorSlot = new FloorSlot();
        $floorSlot->floor_id = $category['floor_id'];
        $floorSlot->categorie_id = $category['category_id'];
        
        $name = sprintf('%02d', $startNumber);
        $floorSlot->name = $name;
        $startNumber++;

        $floorSlot->save();

        $floors[] = $floorSlot;
    }

    return response()->json(['message' => 'Floor slots created successfully', 'floors' => $floors]);
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
                // $validatedData = $request->validate([
        //     'floor_id' => 'required',
        //     'categorie_id' => 'required',
        //     'name' => 'required',
        // ]);
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
