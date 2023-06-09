<?php

namespace App\Http\Controllers;

use App\Models\Parkzone;
use App\Models\Category;
use App\Models\Quartier;
use App\Models\CategoryWiseParkzoneSlot;
use App\Models\CategoryWiseParkzoneSlotNumber;
use App\Models\Floor;
use Illuminate\Support\Facades\Storage;
use App\Models\Gallery;




use App\Models\cities;
use App\Models\FloorSlot;
use App\Models\Side_slot;
use App\Models\Sides;
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


    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $validated = $request->validate([
    //         'name' => 'bail|required|unique:parkzones',
    //         'type' => 'bail|required',
    //         'mode' => 'bail|required',
    //         'remarks' => 'bail|nullable|min:3',
    //         'lat' => 'bail|required',
    //         'lng' => 'bail|required',
    //         'agent_id' => 'bail|required|array', // Ensure agent_id is an array
    //         'agent_id.*' => 'exists:users,id',
    //         'quartier_id' => 'required',
    //     ]);


    //     $parkzone = new Parkzone();
    //     $parkzone->name = $request->name;
    //     $parkzone->type = $request->type;
    //     $parkzone->mode = $request->mode;
    //     $parkzone->remarks = $request->remarks;
    //     $parkzone->lat = $request->lat;
    //     $parkzone->lng = $request->lng;
    //     $parkzone->quartier_id = $request->quartier_id;
    //     $parkzone->save();



    //     // Attach agent_id values to the parkzone using the pivot table
    //     $parkzone->agents()->attach($request->agent_id);
    //     // dd($request->all());

    //     return redirect()
    //         ->route('parkzones.index')
    //         ->with(['flashMsg' => ['msg' => 'Parkzone successfully added.', 'type' => 'success']]);
    // }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'bail|required|unique:parkzones',
            'type' => 'bail|required',
            'mode' => 'bail|required',
            'remarks' => 'bail|nullable|min:3',
            'lat' => 'bail|required',
            'lng' => 'bail|required',
            'image' => 'bail|required|image|mimes:jpeg,png,jpg,gif|max:2048', // Updated validation rule for the image field
            'agent_id' => 'bail|required|array',
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

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('parkzone', 'public');
            $parkzone->image = $imagePath;
        }

        $parkzone->save();

        // Attach agent_id values to the parkzone using the pivot table
        $parkzone->agents()->attach($request->agent_id);

        return redirect()
            ->route('parkzones.index')
            ->with(['flashMsg' => ['msg' => 'Parkzone successfully added.', 'type' => 'success']]);
    }

    // public function createGallery(Request $request, $id)
    // {
    //     $request->validate([
    //         'galleryImages' => 'required|array',
    //         'galleryImages.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $parkzone = Parkzone::findOrFail($id);

    //     foreach ($request->file('galleryImages') as $image) {
    //         $imageName = $image->store('gallery', 'public');

    //         $gallery = new Gallery([
    //             'parkzone_id' => $parkzone->id,
    //             'image' => $imageName,
    //         ]);

    //         $gallery->save();
    //     }

    //     return redirect()->back()->with('success', 'Gallery added successfully');
    // }


    public function createGallery(Request $request, $id)
    {
        $galleryImages = $request->file('galleryImages');

        if (empty($galleryImages)) {
            return response()->json(['error' => 'Gallery images are required and must be an array']);
        }

        $parkzone = Parkzone::findOrFail($id);

        foreach ($galleryImages as $image) {
            if (!$image->isValid() || !in_array($image->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif'])) {
                return response()->json(['error' => 'Invalid image format']);
            }

            $imageName = $image->store('gallery', 'public');

            $gallery = new Gallery([
                'parkzone_id' => $parkzone->id,
                'image' => $imageName,
            ]);

            $gallery->save();
        }

        return response()->json(['success' => 'Gallery added successfully']);
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
        // $parkzone->update([
        //     'name'     => $validated['name'],
        //     'remarks'  => $validated['remarks'],
        //     'mode'     => $validated['mode'],
        //     'lat'      => $validated['lat'],
        //     'lng'      => $validated['lng'],
        //     'type'     => $validated['type'],
        //     'quartier_id' => $validated['quartier_id'],
        // ]);

        $parkzone->name = $request->name;
        $parkzone->type = $request->type;
        $parkzone->mode = $request->mode;
        $parkzone->remarks = $request->remarks;
        $parkzone->lat = $request->lat;
        $parkzone->lng = $request->lng;
        $parkzone->quartier_id = $request->quartier_id;
        $parkzone->save();

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
    public function checkiffloorsideexist($id, $type)
    {
        if ($type == 'floor') {
            $parkzone = Parkzone::find($id);
            $floors = Floor::where('parkzone_id', $parkzone->id)->get();
            if (count($floors) > 0) {
                return response()->json(null, 404);
            } else {
                return response()->json(null, 200);
            }
        } elseif ($type == 'side') {
            $parkzone = Parkzone::find($id);
            $sides = Sides::where('parkzone_id', $parkzone->id)->get();
            if (count($sides) > 0) {
                return response()->json(null, 404);
            } else {
                return response()->json(null, 200);
            }
        } elseif ($type == 'standard') {
            $parkzone = Parkzone::find($id);
            $categoryWiseParkzoneSlots = CategoryWiseParkzoneSlot::where('parkzone_id', $parkzone->id)->get();
            if (count($categoryWiseParkzoneSlots) > 0) {
                $categoryWiseParkzoneSlots = CategoryWiseParkzoneSlotNumber::where('parkzone_id', $parkzone->id)->get();
                return response()->json($categoryWiseParkzoneSlots, 404);
            } else {
                return response()->json(null, 200);
            }
        }
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
    public function readApi()
    {
        $data = [];
        $parkzones = Parkzone::all();
        $categories = Category::all();
        foreach ($parkzones as $index => $parkzone) {
            $data[$index] = $parkzone->getAttributes();

            if ($parkzone->type == 'standard') {
                foreach ($categories as $categorie) {
                    $data[$index]["category"][$categorie->type]["total"] = count(CategoryWiseParkzoneSlot::where('parkzone_id', $parkzone->id)->where('category_id', $categorie->id)->get());
                    $data[$index]["category"][$categorie->type]["available"] = count(CategoryWiseParkzoneSlot::where('parkzone_id', $parkzone->id)->where('category_id', $categorie->id)->whereDoesntHave('active_parking')->get());
                }
            } elseif ($parkzone->type == 'floor') {
                foreach ($categories as $categorie) {
                    $data[$index]["category"][$categorie->type]["total"] = count(FloorSlot::whereHas('floor', function ($query) use ($parkzone) {
                        $query->where('parkzone_id', $parkzone->id);
                    })->where('categorie_id', $categorie->id)->get());
                    $data[$index]["category"][$categorie->type]["available"] = count(FloorSlot::whereHas('floor', function ($query) use ($parkzone) {
                        $query->where('parkzone_id', $parkzone->id);
                    })->where('categorie_id', $categorie->id)->whereDoesntHave('active_parking')->get());
                }
            } elseif ($parkzone->type == 'side') {
                foreach ($categories as $categorie) {
                    $data[$index]["category"][$categorie->type]["total"] = count(Side_slot::whereHas('side', function ($query) use ($parkzone) {
                        $query->where('parkzone_id', $parkzone->id);
                    })->where('category_id', $categorie->id)->get());
                    $data[$index]["category"][$categorie->type]["available"] = count(Side_slot::whereHas('side', function ($query) use ($parkzone) {
                        $query->where('parkzone_id', $parkzone->id);
                    })->where('category_id', $categorie->id)->whereDoesntHave('active_parking')->get());
                }
            }
        }
        foreach ($data as $index => $da) {
            foreach ($da["category"] as $inde => $d) {
                if ($data[$index]["category"][$inde]["available"] == 0) {
                    unset($data[$index]["category"][$inde]);
                }
            }
        }
        return response()->json($data);
    }

    public function readApiById($id)
    {
        $parkzones = Parkzone::find($id);
        if ($parkzones->type == 'standard') {
            $data = CategoryWiseParkzoneSlot::where('parkzone_id', $id)->with('category')->get();
        } elseif ($parkzones->type == 'floor') {
            $data = FloorSlot::whereHas('floor', function ($query) use ($parkzones) {
                $query->where('parkzone_id', $parkzones->id);
            })->with('category')->get();
        } elseif ($parkzones->type == 'side') {
            $data = Side_slot::whereHas('side', function ($query) use ($parkzones) {
                $query->where('parkzone_id', $parkzones->id);
            })->with('category')->get();
        }
        // dd($data);
        return response()->json($data->groupBy('category.type'));
    }
    public function readApiByIdAndCat($id, $cat)
    {
        $parkzone = Parkzone::find($id);
        $categorie = Category::where('type', $cat)->first();
        if ($parkzone->type == 'standard') {
            $data = CategoryWiseParkzoneSlot::where('parkzone_id', $id)->where('category_id', $categorie->id)->get();
            return response()->json([
                "slots" => $data->groupBy('floor.level'),
                "type" => "standard"
            ]);
        } elseif ($parkzone->type == 'floor') {
            $data = FloorSlot::whereHas('floor', function ($query) use ($parkzone) {
                $query->where('parkzone_id', $parkzone->id);
            })->where('categorie_id', $categorie->id)->with('floor')->get();
            return response()->json([
                "slots" => $data->groupBy('floor.level'),
                "type" => "floor"
            ]);
        } elseif ($parkzone->type == 'side') {
            $data = Side_slot::whereHas('side', function ($query) use ($parkzone) {
                $query->where('parkzone_id', $parkzone->id);
            })->where('category_id', $categorie->id)
            ->with('side')
            ->get();
            return response()->json([
                "slots" => $data->groupBy('side.side'),
                "type" => "side"
            ]);
        }
    }
    public function readTariffByIdAndCat($id, $cat)
    {
        $parkzone = Parkzone::find($id)->with("Quartier", "Quartier.city")->first();
        $categorie = Category::where('type', $cat)->first();
        return response()->json([
            "parkzone" => $parkzone,
            "tariff" => $parkzone->tariff_by_cat($categorie->id)->orderBy('number_hour')->get(),
        ]);
    }
}
