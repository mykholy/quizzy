<?php

namespace App\Http\Requests\API;

use App\Helpers\APIRequest;

class UpdateStudentAPIRequest extends APIRequest
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
        $id=auth('api-student')->id();
        return [
            'name' => 'required',
            'password' => 'nullable|min:6',
            'email' => "nullable|unique:students,email,$id",
            'photo' => 'nullable|file',
            'phone' => "nullable|unique:students,phone,$id",
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'date_of_birth' => 'nullable|date_format:Y-m-d',
            'username' => "nullable|unique:students,username,$id",
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
