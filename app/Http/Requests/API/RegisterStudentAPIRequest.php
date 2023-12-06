<?php

namespace App\Http\Requests\API;

use App\Helpers\APIRequest;

class RegisterStudentAPIRequest extends APIRequest
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
            'email' => 'required|unique:students',
            'photo' => 'nullable|file',
            'phone' => 'nullable|unique:students',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'date_of_birth' => 'nullable|data_format:Y-m-d',
            'username' => 'nullable|unique:students',
            'governorate' => 'nullable',
            'area' => 'nullable',
            'residence_area' => 'nullable',
            'specialization' => 'nullable',
            'provider_id' => 'nullable',
            'provider_type' => 'nullable',
            'device_token' => 'nullable',
        ];
    }


}
