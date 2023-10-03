<?php

namespace App\Http\Requests\API;

use App\Helpers\APIRequest;

class RegisterClientAPIRequest extends APIRequest
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
            'name' => 'required',
            'password' => 'required|min:6',
            'email' => 'required|unique:clients',
            'photo' => 'nullable|file',
            'phone' => 'nullable|unique:clients',
            'car_id' => 'nullable|exists:cars,id',
            'car_model' => 'nullable',
            'provider_id' => 'nullable',
            'provider_type' => 'nullable',
            'device_token' => 'nullable',
        ];
    }


}
