<?php

namespace App\Http\Requests\API;

use App\Helpers\APIRequest;

class UpdateTeacherAPIRequest extends APIRequest
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
        $id=auth('api-teacher')->id();
        return [
            'name' => 'required',
            'password' => 'nullable|min:6',
            'email' => "nullable|unique:teachers,email,$id",
            'photo' => 'nullable|file',
            'device_token' => 'nullable',
        ];
    }


}
