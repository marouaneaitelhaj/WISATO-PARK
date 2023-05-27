<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryWiseParkzoneSlot;
use App\Models\category_category_wise_parkzone_slot;

use App\Models\Parkzone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OperatorsInPark;

class CategoryWiseParkzoneSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $parkingSlot = new CategoryWiseParkzoneSlot();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['category','createBy', 'parkzone', 'operator'];
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
                $search['slot_name'] = $request->input('search')['value'];
                $search['slotId'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }
            $parkingSlot = $parkingSlot->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($parkingSlot);
        }

        return view('content.parking_settings.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::where('status', 1)->get();
        $parkzones = Parkzone::where('status', 1)->get();
        return view('content.parking_settings.create')->with(['categories' => $categories, 'parkzones' => $parkzones]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'slot_name' => 'bail|required|min:1|max:5',
            'identity' => 'bail|nullable|min:5',
            'remarks' => 'bail|nullable|min:5',
            'operator' => 'bail|required',
        ]);

        $validator->after(function ($validator) use ($request) {
            $oldSlot =  CategoryWiseParkzoneSlot::where(['parkzone_id' => $request->parkzone_id, 'slot_name' => $request->slot_name])->count();
            if ($oldSlot) {
                $validator->errors()->add('slot_name', 'This slot name has been used.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create a new record in category_wise_parkzone_slots
        $categoryWiseParkzoneSlot = new CategoryWiseParkzoneSlot();
        $categoryWiseParkzoneSlot->identity = $request->identity;
        $categoryWiseParkzoneSlot->remarks = $request->remarks;
        $categoryWiseParkzoneSlot->parkzone_id = $request->parkzone_id;
        $categoryWiseParkzoneSlot->slot_name = $request->slot_name;
        $categoryWiseParkzoneSlot->slotId = random_int(10000, 99999);
        $categoryWiseParkzoneSlot->created_by = auth()->id();
        $categoryWiseParkzoneSlot->save();
        // dd($request);
        // Create a new record in operators_in_parks
        foreach ($request->operator as $operatorId) {
            $operatorInPark = new OperatorsInPark();
            $operatorInPark->category_wise_parkzone_slot_id = $categoryWiseParkzoneSlot->id;
            $operatorInPark->operator_id = $operatorId;
            $operatorInPark->save();
        }
        foreach ($request->category as $index => $category) {
            $category_category_wise_parkzone_slot = new category_category_wise_parkzone_slot();
            $category_category_wise_parkzone_slot->category_id = $index;
            $category_category_wise_parkzone_slot->slot_id = $categoryWiseParkzoneSlot->id;
            $category_category_wise_parkzone_slot->slot_number = $category;
            $category_category_wise_parkzone_slot->save();
        }

        return redirect()
            ->route('parking_settings.index')
            ->with(['flashMsg' => ['msg' => 'Parking slot successfully added.', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryWiseParkzoneSlot  $parking_setting
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryWiseParkzoneSlot $parking_setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryWiseParkzoneSlot  $parking_setting
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryWiseParkzoneSlot $parking_setting)
    {
        $categories = Category::where('status', 1)->get();
        $parkzones = Parkzone::where('status', 1)->get();
        return view('content.parking_settings.edit')->with(['categories' => $categories, 'parkzones' => $parkzones, 'parking_setting' => $parking_setting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryWiseParkzoneSlot  $parking_setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryWiseParkzoneSlot $parking_setting)
    {
        $validator = Validator::make($request->all(), [
            'slot_name' => 'bail|required|min:1|max:5',
            'identity' => 'bail|nullable|min:5',
            'remarks' => 'bail|nullable|min:5'
        ]);

        $validator->after(function ($validator) use ($request, $parking_setting) {
            $oldSlot =  CategoryWiseParkzoneSlot::where(['category_id' => $request->category_id, 'parkzone_id' => $request->parkzone_id, 'slot_name' => $request->slot_name])->where('id', '!=', $parking_setting->id)->count();
            if ($oldSlot) {
                $validator->errors()->add('slot_name', 'This slot name has been used.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();;
        }

        $data = [
            'identity' => $request->identity,
            'remarks' => $request->remarks,
            'category_id' => $request->category_id,
            'parkzone_id' => $request->parkzone_id,
            'slot_name' => $request->slot_name
        ];

        $parking_setting->update($data);

        return redirect()
            ->route('parking_settings.index')
            ->with(['flashMsg' => ['msg' => 'Parking slot successfully updated.', 'type' => 'success']]);
    }

    /**
     * Update the status
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parkzone  $parkzone
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request, CategoryWiseParkzoneSlot $parking_setting)
    {
        if ($parking_setting->active_parking) {
            return back()->with(['flashMsg' => ['msg' => 'This Slot has already been used in an active parking.', 'type' => 'warning']]);
        } else {
            if ($parking_setting->status == 1) {
                $parking_setting->update(['status' => 0]);
            } else {
                $parking_setting->update(['status' => 1]);
            }

            return back()->with(['flashMsg' => ['msg' => 'Status successfully changed.', 'type' => 'success']]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryWiseParkzoneSlot  $parking_setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryWiseParkzoneSlot $parking_setting)
    {
        $parking_setting->delete();
    }
    public function readwise()
    {
        return CategoryWiseParkzoneSlot::with('category')->get();
    }
}
