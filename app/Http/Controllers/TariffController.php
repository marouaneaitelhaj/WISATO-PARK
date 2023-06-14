<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTariffRequest;
use App\Http\Requests\UpdateTariffRequest;
use App\Models\Parking;
use App\Models\Parkzone;
use App\Models\Quartier;
use App\Models\Slot;
use Carbon\Carbon;
use Carbon\CarbonInterval;




class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $tariff = new Tariff();
            $limit = 10;
            $offset = 0;
            $search = [];
            $where = [];
            $with = ['category','quartier','parkzone'];
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
                $search['start_date'] = $request->input('search')['value'];
                $search['end_date'] = $request->input('search')['value'];
                $search['amount'] = $request->input('search')['value'];
                $search['min_amount'] = $request->input('search')['value'];
            }

            if ($request->input('where')) {
                $where = $request->input('where');
            }

            $tariff = $tariff->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
            return response()->json($tariff);
        }

        return view('content.tariff.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $parkzones = Parkzone::all();
        $quartiers = Quartier::all(); // Fetch all quartiers
        return view('content.tariff.create', ['categories' => $categories, 'parkzones' => $parkzones, 'quartiers' => $quartiers]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreTariffRequest  $request
     * @return \Illuminate\Http\Response
     */









    public function store(Request $request)
{
    try {
        $start = Carbon::parse($request->input('start_date'));
        $end = Carbon::parse($request->input('end_date'));
        $interval = CarbonInterval::hour();

        $tariffs = collect();
        $amount = $request->input('amount');
        $numberHour = 1;

        for ($i = 0; $i < $end->diffInHours($start); $i++) {
            $tariff = Tariff::create([
                'name'                => $request->input('name'),
                'category_id'         => $request->input('category_id'),
                'start_date'          => $start,
                'end_date'            => $end,
                'min_amount'          => $request->input('min_amount'),
                'amount'              => $amount,
                'status'              => $request->input('status'),
                'created_by'          => $request->user()->id,
                'modified_by'         => $request->user()->id,
                'validate_start_date' => $request->input('validate_start_date'),
                'validate_end_date'   => $request->input('validate_end_date'),
                'day'                 => $request->input('day'),
                'quartier_id'         => $request->input('quartier_id'),
                'parkzone_id'         => $request->input('parkzone_id'),
                'shadow_amount'       => $request->input('shadow_amount'),
                'number_hour'         => $numberHour,
                'total_amount'        => $amount * $numberHour,
            ]);

            $tariffs->push($tariff);
            $numberHour++;
        }

        $tariff24 = Tariff::create([
            'name'                => $request->input('name'),
            'category_id'         => $request->input('category_id'),
            'start_date'          => $start,
            'end_date'            => $end,
            'min_amount'          => $request->input('min_amount'),
            'amount'              => $amount,
            'status'              => $request->input('status'),
            'created_by'          => $request->user()->id,
            'modified_by'         => $request->user()->id,
            'validate_start_date' => $request->input('validate_start_date'),
            'validate_end_date'   => $request->input('validate_end_date'),
            'day'                 => $request->input('day'),
            'quartier_id'         => $request->input('quartier_id'),
            'parkzone_id'         => $request->input('parkzone_id'),
            'shadow_amount'       => $request->input('shadow_amount'),
            'number_hour'         => 24,
            'total_amount'        => $request->input('24h_amount') ?: ($amount * 24),
        ]);

        $tariffs->push($tariff24);
    } catch (\PDOException $e) {
        return redirect()
            ->back()
            ->withInput()
            ->with(['flashMsg' => ['msg' => $e->getMessage(), 'type' => 'error']]);
    }

    return redirect()
        ->route('tariff.index')
        ->with(['flashMsg' => ['msg' => 'Tariff successfully added.', 'type' => 'success']]);
}










    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tariff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function edit(Tariff $tariff)
    {
        $categories = Category::where('status', 1)->get();
        return view('content.tariff.edit')->with(['tariff' => $tariff, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateTariffRequest  $request
     * @param  \App\Models\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTariffRequest $request, Tariff $tariff)
    {
        $validated = $request->validated();

        try {

            $tariff = Tariff::where('id', $tariff->id)->update([

                'name'          => $validated['name'],
                'category_id'   => $validated['category_id'],
                'start_date'    => $validated['start_date'],
                'end_date'      => $validated['end_date'],
                'min_amount'    => $validated['min_amount'],
                'amount'        => $validated['amount'],
                'status'        => $validated['status'],
                'modified_by'   => $request->user()->id
            ]);
        } catch (\PDOException $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
        }

        return redirect()
            ->route('tariff.index')
            ->with(['flashMsg' => ['msg' => 'Tariff successfully updated.', 'type' => 'success']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tariff $tariff)
    {
        $tariff->delete();
    }
}
