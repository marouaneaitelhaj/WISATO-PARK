<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FloorSlot;
use App\Models\CountFloorCat;
use App\Models\Floor;

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
    
        foreach ($categories as $category) {
            $categoryID = $category['category_id'];
            $count = FloorSlot::where('categorie_id', $categoryID)->count();
    
            $existingEntry = CountFloorCat::where('floor_id', $category['floor_id'])
                ->where('category_id', $categoryID)
                ->first();
    
            if ($existingEntry) {
                $existingEntry->count = $count;
                $existingEntry->save();
            } else {
                CountFloorCat::create([
                    'floor_id' => $category['floor_id'],
                    'category_id' => $categoryID,
                    'count' => $count,
                ]);
            }
        }
    
        return response()->json(['message' => 'Floor slots created successfully', 'floors' => $floors]);
    }
//     public function showSlots($floorId)
// {
//     $floor = Floor::findOrFail($floorId);
//     $slots = $floor->floorSlots;

//     return response()->json($slots);
// }



    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($floorId)
    {
        $floor = Floor::findOrFail($floorId);
    $slots = $floor->floorSlots;

    if ($slots) {
        return response()->json($slots->toArray());
    } else {
        return response()->json([]);
    }


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
        $slot = FloorSlot::findOrFail($id);
        $slot->shadow = $request->input('shadow');
        $slot->status = $request->input('status');
        $slot->save();

        return response()->json(['message' => 'Slot updated successfully', 'slot' => $slot]);
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
