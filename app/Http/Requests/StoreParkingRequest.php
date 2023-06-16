<?php

namespace App\Http\Requests;

use App\Models\Parking;
use App\Models\Tariff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreParkingRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'vehicle_no'    => 'bail|required|string',
			'category_id'   => 'bail|required|integer',
			// 'slot_id'   	=> 'bail|required|integer',
			'driver_mobile' => 'bail|nullable|string',
			'driver_name'   => 'bail|nullable|string',
		];
	}

	public function withValidator(Validator $validator){        
		$validator->after(function(Validator $validator){    
			if($this->input('category_id') == null){
				$validator->errors()->add('category_id','No tariff found');
			}

			$activeParking = Parking::where('vehicle_no', $this->request->get('vehicle_no'))->where('out_time', null)->first();

			if($activeParking){
				$validator->errors()->add('vehicle_no', 'This vehicle has currently parked in ' . $activeParking->slot->name . ' slot.');
			}

		});
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'slot_id.required' => 'The system doesn’t have proper slot information for this category type',
		];
	}
}
