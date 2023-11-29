<?php

namespace App\Http\Requests\API;

use App\Helpers\APIRequest;

class SocailRegisterStudentAPIRequest extends APIRequest
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
            'name' => 'nullable',
            'email' => 'nullable',
            'photo' => 'nullable|file',
            'phone' => 'nullable',
            'car_id' => 'nullable|exists:cars,id',
            'car_model' => 'nullable',
            'provider_id' => 'required',
            'provider_type' => 'required',
            'device_token' => 'nullable',
        ];
    }


}
