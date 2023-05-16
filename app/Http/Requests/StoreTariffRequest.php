<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTariffRequest extends FormRequest
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
            'name'          => 'bail|required|string',
            'category_id'   => 'bail|required|integer',
            'start_date'    => 'bail|required|date',
            'end_date'      => 'bail|required|date|after:start_date',
            'min_amount'    => 'bail|required|numeric|min:1',
            'amount'        => 'bail|required|numeric|min:1',            
            'status'        => 'bail|required|boolean',
        ];
    }
}
