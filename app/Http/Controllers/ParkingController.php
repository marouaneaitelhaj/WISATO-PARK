<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Category;
use App\Models\FloorSlot;
use App\Models\Side_slot;
use App\Models\Tariff;
use Illuminate\Http\Request;
use App\Http\Requests\StoreParkingRequest;
use App\Http\Requests\UpdateParkingRequest;
use App\Http\Requests\PayParkingRequest;
use App\Models\CategoryWiseParkzoneSlot;
use App\Models\Parkzone;
use App\View\Components\floor;
use Exception;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\This;

class ParkingController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->wantsJson()) {
			$parkings = new Parking();
			$limit = 10;
			$offset = 0;
			$search = [];
			$where = [];
			$with = ['category', 'create_by', 'slot'];
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
				$search['barcode'] = $request->input('search')['value'];
				$search['vehicle_no'] = $request->input('search')['value'];
				$search['driver_name'] = $request->input('search')['value'];
				$search['driver_mobile'] = $request->input('search')['value'];
			}

			if ($request->input('where')) {
				$where = $request->input('where');
			}

			$parkings = $parkings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
			return response()->json($parkings);
		}
		$chefId = auth()->user()->id;
		$data['categories'] = Category::where('status', 1)->get();
		$data['currently_parking'] = Parking::where('out_time', NULL)->count();
		$data['total_slots'] = CategoryWiseParkzoneSlot::where('category_wise_parkzone_slots.status', 1)
			->whereHas('parkzone', function ($query) use ($chefId) {
				$query->where('status', 1)
					->whereHas('agent_inparkzone', function ($query) use ($chefId) {
						$query->where('agent_id', $chefId); // Add the condition to match the chef ID in the pivot table
					});
			})
			->whereHas('category', function ($query) {
				$query->where('status', '1');
			})->with('active_parking')->count();
		return view('content.parking.list')->with($data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function currentList(Request $request)
	{
		if ($request->wantsJson()) {
			$parkings = new Parking();
			$limit = 10;
			$offset = 0;
			$search = [];
			$where = [];
			$with = ['category', 'create_by', 'slot'];
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
				$search['barcode'] = $request->input('search')['value'];
				$search['vehicle_no'] = $request->input('search')['value'];
				$search['driver_name'] = $request->input('search')['value'];
				$search['driver_mobile'] = $request->input('search')['value'];
			}

			if ($request->input('where')) {
				$where = $request->input('where');
			}

			$where['out_time'] = null;

			$parkings = $parkings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
			return response()->json($parkings);
		}
		$chefId = auth()->user()->id;

		$data['categories'] = Category::where('status', 1)->get();
		$data['currently_parking'] = Parking::where('out_time', NULL)->count();
		if ($chefId == 1) {
			$data['total_slots'] = CategoryWiseParkzoneSlot::where('category_wise_parkzone_slots.status', 1)
				->whereHas('parkzone', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		} else {
			$data['total_slots'] = CategoryWiseParkzoneSlot::where('category_wise_parkzone_slots.status', 1)
				->whereHas('parkzone', function ($query) use ($chefId) {
					$query->where('status', 1)
						->whereHas('agent_inparkzone', function ($query) use ($chefId) {
							$query->where('agent_id', $chefId); // Add the condition to match the chef ID in the pivot table
						});
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		}
		// $data['total_slots'] = 99;
		return view('content.parking.current_list')->with($data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function endedList(Request $request)
	{
		if ($request->wantsJson()) {
			$parkings = new Parking();
			$limit = 10;
			$offset = 0;
			$search = [];
			$where = [];
			$with = ['category', 'create_by', 'slot'];
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
				$search['barcode'] = $request->input('search')['value'];
				$search['vehicle_no'] = $request->input('search')['value'];
				$search['driver_name'] = $request->input('search')['value'];
				$search['driver_mobile'] = $request->input('search')['value'];
			}

			if ($request->input('where')) {
				$where = $request->input('where');
			}

			$where['out_time NOTEQ'] = null;

			$parkings = $parkings->getDataForDataTable($limit, $offset, $search, $where, $with, $join, $orderBy,  $request->all());
			return response()->json($parkings);
		}
		$chefId = auth()->user()->id;

		$data['categories'] = Category::where('status', 1)->get();
		$data['currently_parking'] = Parking::where('out_time', NULL)->count();
		$data['total_slots'] = CategoryWiseParkzoneSlot::where('category_wise_parkzone_slots.status', 1)
			->whereHas('parkzone', function ($query) use ($chefId) {
				$query->where('status', 1)
					->whereHas('agent_inparkzone', function ($query) use ($chefId) {
						$query->where('agent_id', $chefId); // Add the condition to match the chef ID in the pivot table
					});
			})
			->whereHas('category', function ($query) {
				$query->where('status', '1');
			})->with('active_parking')->count();
		// $data['total_slots'] = 99;
		return view('content.parking.ended_list')->with($data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$chefId = auth()->user()->id;

		$data['categories'] = Category::where('status', 1)->get();
		$data['currently_parking'] = Parking::where('out_time', NULL)->count();
		if ($chefId == 1) {
			$data['total_slots'] = CategoryWiseParkzoneSlot::where('category_wise_parkzone_slots.status', 1)
				->whereHas('parkzone', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		} else {
			$data['total_slots'] = CategoryWiseParkzoneSlot::where('category_wise_parkzone_slots.status', 1)
				->whereHas('parkzone', function ($query) use ($chefId) {
					$query->where('status', 1)
						->whereHas('agent_inparkzone', function ($query) use ($chefId) {
							$query->where('agent_id', $chefId); // Add the condition to match the chef ID in the pivot table
						});
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})->with('active_parking')->count();
		}
		// $data['total_slots'] = 99;
		return view('content.parking.create')->with($data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\StoreParkingRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreParkingRequest $request)
	{
		dd($request->all());
		$validated = $request->validated();

		try {

			$parking = Parking::create([
				'slot_id'    	=> $validated['slot_id'],
				'vehicle_no'    => $validated['vehicle_no'],
				'category_id'   => $validated['category_id'],
				'driver_name'   => $validated['driver_name'],
				'driver_mobile' => $validated['driver_mobile'],
				'barcode'       => date('YmdHis') . $request->user()->id,
				'in_time'       => date('Y-m-d H:i:s'),
				'created_by'    => $request->user()->id,
				'modified_by'   => $request->user()->id
			]);
		} catch (\PDOException $e) {

			return redirect()
				->back()
				->withInput()
				->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
		}

		return redirect()
			->route('parking.barcode', ['parking' => $parking->id])
			->with(['flashMsg' => ['msg' => 'Parking successfully added.', 'type' => 'success']]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Parking  $parking_crud
	 * @return \Illuminate\Http\Response
	 */
	public function show(Parking $parking_crud)
	{
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Parking  $parking_crud
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Parking $parking_crud)
	{
		$data['categories'] = Category::where('status', 1)->get();
		$data['currently_parking'] = Parking::where('out_time', NULL)->count();
		$data['parking'] = $parking_crud;
		$data['total_slots'] = CategoryWiseParkzoneSlot::where('category_wise_parkzone_slots.status', 1)
			->whereHas('parkzone', function ($query) {
				$query->where('status', '1');
			})
			->whereHas('category', function ($query) {
				$query->where('status', '1');
			})->with('active_parking')->count();

		return view('content.parking.edit')->with($data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\UpdateParkingRequest  $request
	 * @param  \App\Models\Parking  $parking_crud
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateParkingRequest $request, Parking $parking_crud)
	{
		$validated = $request->validated();

		try {
			if ($parking_crud->status > 2)
				return redirect()
					->back()
					->withInput()
					->with(['flashMsg' => ['msg' => "You are not allow to update parking.", 'type' => 'warning']]);
			$parking = Parking::where('id', $parking_crud->id)->update([

				'slot_id'    	=> $validated['slot_id'],
				'vehicle_no'    => $validated['vehicle_no'],
				'category_id'   => $validated['category_id'],
				'driver_name'   => $validated['driver_name'],
				'driver_mobile' => $validated['driver_mobile'],
				'status' 		=> 2,
				'modified_by'   => $request->user()->id
			]);
		} catch (\PDOException $e) {

			return redirect()
				->back()
				->withInput()
				->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
		}

		return redirect()
			->route('parking.index')
			->with(['flashMsg' => ['msg' => 'Parking successfully updated.', 'type' => 'success']]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Parking  $parking
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Parking $parking_crud)
	{
		$barcodeNo = $parking_crud->barcode;
		$parking_crud->delete();
		return response()->json(['message' => $barcodeNo . ' Parking successfully deleted.']);
	}

	/**
	 * End the specified parking from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Parking  $parking
	 * @return \Illuminate\Http\Response
	 */
	public function end(Request $request, Parking $parking)
	{
		$viewData = [];
		if ($parking->status <= 2) {
			try {
				$tariff = Tariff::getCurrent($parking->category_id);
				if ($tariff == NULL) {
					return redirect()
						->back()
						->withInput()
						->with(['flashMsg' => ['msg' => "Tariff not found for this hour. Please check your tariff information!", 'type' => 'warning']]);
				}

				$eDate = new \DateTime($parking->out_time);
				Session::put('eDate_' . $parking->id, $eDate);
				$dateDiff = $eDate->diff(new \DateTime($parking->in_time));

				// \Exceptio\Utlt::look($dateDiff);
				$hour = $dateDiff->h;
				$amt = $tariff->min_amount;
				if ($dateDiff->days > 0)
					$hour = $dateDiff->h + ($dateDiff->days * 24);
				$hour += ($dateDiff->i / 60);
				if ($hour > 1)
					$amt = $hour * $tariff->amount;

				Session::put('eAmt_' . $parking->id, $amt);
				$viewData['parking'] = $parking;
				$viewData['amt'] = $amt;
				$viewData['amt'] = $tariff->min_amount > $amt ? $tariff->min_amount : $amt;
				return view('content.parking.end')->with($viewData);
			} catch (Exception $e) {

				return redirect()
					->back()
					->withInput()
					->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
			}
		}

		$viewData['parking'] = $parking;
		return view('content.parking.end')->with($viewData);
	}

	/**
	 * Print the specified parking from storage.
	 *
	 * @param  \App\Models\Parking  $parking
	 * @return \Illuminate\Http\Response
	 */
	public function barcode(Parking $parking)
	{
		return view('content.parking.barcode')->with(['parking' => $parking]);
	}

	/**
	 * End the specified parking from storage.
	 *
	 * @param  \Illuminate\Http\PayParkingRequest  $request
	 * @param  \App\Models\Parking  $parking
	 * @return \Illuminate\Http\Response
	 */
	public function pay(PayParkingRequest $request, Parking $parking)
	{
		if ($parking->status != 3) {
			try {
				$validated = $request->validated();
				$parking->out_time = Session::has('eDate_' . $parking->id) ? Session::get('eDate_' . $parking->id) : date('Y-m-d H:i:s');


				//amount 
				if (Session::has('eAmt_' . $parking->id)) {
					$amt = Session::get('eAmt_' . $parking->id);
				} else {
					$tariff = Tariff::getCurrent($parking->category_id);
					$dateDiff = $parking->out_time->diff(new \DateTime($parking->in_time));

					$hour = $dateDiff->h;
					$amt = $tariff->min_amount;
					if ($dateDiff->days > 0)
						$hour = $dateDiff->h + ($dateDiff->days * 24);
					$hour += ($dateDiff->i / 60);
					if ($hour > 1)
						$amt = $hour * $tariff->amount;
				}

				$parking->amount = $amt;
				$parking->modified_by = $request->user()->id;
				$parking->update();
				$parking->paid = $validated['paid_amt'];
				$parking->status = 4;
				$parking->update();

				Session::forget('eAmt_' . $parking->id);
				Session::forget('eDate_' . $parking->id);

				$viewData['flashMsg'] = ['msg' => 'Parking checkout & payment successfully.', 'type' => 'success'];
				$viewData['parking'] = $parking;

				return redirect()
					->route('parking.end', ['parking' => $parking->id])
					->with($viewData);
			} catch (Exception $e) {

				return redirect()
					->back()
					->withInput()
					->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
			}
		}

		$viewData['parking'] = $parking;
		return view('content.parking.end')->with($viewData);
	}

	/**
	 * get slot by using category id.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function parkingSlot(Request $request, $category_id)
	{
		$chefId = auth()->user()->id;
		$slots = [];
		if ($chefId == 1) {
			$standard = CategoryWiseParkzoneSlot::where('category_id', $category_id)
				->where('status', 1)
				->whereHas('parkzone', function ($query) {
					$query->where('status', '1');
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})
				->with('category')
				->with('parkzone')
				->get();
			$floor = FloorSlot::where('categorie_id', $category_id)
				->with('floor.parkzone')
				->with('Category')
				->get();
			foreach ($floor as $key => $value) {
				$floor[$key]->parkzone = $value->floor->parkzone;
			}
			$side = Side_slot::where('category_id', $category_id)
				->with('side.parkzone')
				->with('category')
				->get();
			foreach ($side as $key => $value) {
				$side[$key]->parkzone = $value->side->parkzone;
			}
			// return (['standard' => $standard[0]['parkzone'], 'floor' => $floor[0]['parkzone'], 'side' => $side[0]['parkzone']]);
			$slots = $standard->merge($floor)->merge($side);
		} else {
			$slots = CategoryWiseParkzoneSlot::where('category_id', $category_id)
				->where('status', 1)
				->whereHas('parkzone', function ($query) use ($chefId) {
					$query->where('status', 1)
						->whereHas('agent_inparkzone', function ($query) use ($chefId) {
							$query->where('agent_id', $chefId); // Add the condition to match the chef ID in the pivot table
						});
				})
				->whereHas('category', function ($query) {
					$query->where('status', '1');
				})
				->with('parkzone')
				->get();
		}
		return view('content.parking.slot_list')->with(['slots' => $slots, 'id' => $request->id])->render();
	}


	/**
	 * End the specified parking from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function quick_end(Request $request)
	{
		try {
			$parking = Parking::where([
				['barcode', $request->input('barcode')],
				['status', '<=', 2],
			])->first();
			if ($parking == null) {
				return redirect()
					->back()
					->withInput()
					->with(['flashMsg' => ['msg' => "This barcode doesn't exist.", 'type' => 'warning']]);
			} else {
				$viewData['parking'] = $parking;

				return redirect()
					->route('parking.end', ['parking' => $parking->id])
					->with($viewData);
			}
		} catch (Exception $e) {

			return redirect()
				->back()
				->withInput()
				->with(['flashMsg' => ['msg' => $this->getMessage($e), 'type' => 'error']]);
		}
	}
	public $initialMarkers = [];
	public function maps()
	{
		$markers = Parkzone::get();
		foreach ($markers as $marker) {
			$newMarker = [
				'position' => [
					'lat' => $marker->lat,
					'lng' => $marker->lng
				],
				'draggable' => true
			];
			array_push($this->initialMarkers, $newMarker);
		}
		$initialMarkers = $this->initialMarkers;
		return view('client.nearby', compact('initialMarkers'));
	}
	public function addMarker()
	{
	}
}
