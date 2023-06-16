<?php

namespace App\Http\Requests;

use App\Models\Parking;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Tariff;
class UpdateParkingRequest extends FormRequest
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
            // 'slot_id'       => 'bail|required',
            'vehicle_no'    => 'bail|required|string',
            'category_id'   => 'bail|required|integer',
            'driver_name'   => 'bail|nullable|string',
            'driver_mobile' => 'bail|nullable|string',
        ];
    }

    public function withValidator($validator){        
        $validator->after(function($validator){            
            if(Tariff::getCurrent($this->input('category_id')) == null){
                $validator->errors()->add('category_id','No tariff found');
            }

            $activeParking = Parking::where('vehicle_no', $this->request->get('vehicle_no'))->where('id', '!=', $this->route('parking_crud')->id)->where('out_time', null)->first();

            if ($activeParking) {
                $validator->errors()->add('vehicle_no', 'This vehicle has currently parked in ' . $activeParking->slot->name . ' slot.');
            }
        });
    }
}
