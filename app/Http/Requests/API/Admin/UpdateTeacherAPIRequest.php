<?php

namespace App\Http\Requests\API\Admin;

use App\Models\Admin\Teacher;
use InfyOm\Generator\Request\APIRequest;

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
        $rules = Teacher::$rules;
        $rules['email'] = $rules['email']. ",'email'," .$this->route("teacher");
        return $rules;
    }
}
