<?php

namespace App\Http\Requests\API;

use App\Helpers\APIRequest;

class LoginTeacherAPIRequest extends APIRequest
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
        $rules = [

            'password' => 'required',
        ];
        if (request('type') == "phone")
            $rules['phone'] = 'required';
        else
            $rules['email'] = 'required';

        return $rules;

    }


}
