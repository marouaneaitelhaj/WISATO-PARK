<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class StoreUserInformation extends FormRequest
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
            'name'            => [
                'bail',
                'required',
                'string',
                'max:191',
                Rule::unique('users', 'name')->ignore($this->route('user'))
            ],
            'Phone'     => [
                'bail',
                'required',
                'string',
                'max:191',
            ],
            'email'           => [
                'bail',
                'required',
                'email',
                'max:191',
                Rule::unique('users')->ignore($this->route('user'))
            ],
            'role'            => 'bail|required_if:required_role,true|integer',
            'password'        => 'bail|required_if:required_password,true|confirmed|max:191',
            // 'cin'             => 'required|string|max:191', // New rule for the 'cin' field

        ];
    }

    public function withValidator($validator)
    {           
        $validator->after(function ($validator) {
            $userParam = $this->route('user');            
            if(gettype($userParam) == 'object')
                $userParam = $userParam->id;
            if($this::user()->id == $userParam
                && !Hash::check($validator->getData()['currentPassword'], $this::user()->makeVisible('password')->password)                
            ){
                $validator->errors()->add('currentPassword', 'Current Password is not matched.');
            }
            elseif (
                $this::user()
                && Route::currentRouteName() !== 'user.store'
                && !$this::user()->hasRole('admin')
                && !Hash::check($validator->getData()['currentPassword'], $this::user()->makeVisible('password')->password)
            ) {
                $validator->errors()->add('currentPassword', 'Current Password is not matched.');
            }

            if ((!$this::user() || !$this->route('user')) && !$validator->getData()['password']) {
                $validator->errors()->add('password', 'Password is required.');
            }
        });
    }
}
