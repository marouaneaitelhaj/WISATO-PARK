<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryWiseParkzoneSlot;
use App\Models\CategoryWiseParkzoneSlotNumber;
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
            $with = ['createBy', 'parkzone', 'category'];
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
                $search['name'] = $request->input('search')['value'];
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
        CategoryWiseParkzoneSlot::where('parkzone_id', $request->parkzone_id)->delete();
        CategoryWiseParkzoneSlotNumber::where('parkzone_id', $request->parkzone_id)->delete();
        foreach ($request->all() as $key => $value) {
            if ($key !== 'parkzone_id' && $key !== 'side') {
                for ($i = 0; $i < $value; $i++) {
                    $CategoryWiseParkzoneSlot = new CategoryWiseParkzoneSlot();
                    $CategoryWiseParkzoneSlot->parkzone_id = $request->parkzone_id;
                    $CategoryWiseParkzoneSlot->category_id = $key;
                    $categories = Category::where('id', $key)->first();
                    $CategoryWiseParkzoneSlot->name = strtok($categories->type, ' ') . '-' . count(CategoryWiseParkzoneSlot::all()) + 1;
                    $CategoryWiseParkzoneSlot->created_by = auth()->user()->id;
                    $CategoryWiseParkzoneSlot->save();
                }
                // call the function to store slot number
                $CategoryWiseParkzoneSlotNumber = new CategoryWiseParkzoneSlotNumber();
                $CategoryWiseParkzoneSlotNumber->parkzone_id = $request->parkzone_id;
                $CategoryWiseParkzoneSlotNumber->category_id = $key;
                $CategoryWiseParkzoneSlotNumber->slot_number = $value;
                $CategoryWiseParkzoneSlotNumber->save();
            }
        }
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
            'name' => 'bail|required|min:1|max:5',
            'identity' => 'bail|nullable|min:5',
            'remarks' => 'bail|nullable|min:5'
        ]);

        $validator->after(function ($validator) use ($request, $parking_setting) {
            $oldSlot =  CategoryWiseParkzoneSlot::where(['category_id' => $request->category_id, 'parkzone_id' => $request->parkzone_id, 'name' => $request->name])->where('id', '!=', $parking_setting->id)->count();
            if ($oldSlot) {
                $validator->errors()->add('name', 'This slot name has been used.');
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
            'name' => $request->name
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
