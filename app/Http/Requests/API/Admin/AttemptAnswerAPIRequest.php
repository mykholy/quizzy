<?php

namespace App\Http\Requests\API\Admin;

use App\Helpers\APIRequest;
use App\Models\Admin\AttemptAnswer;


class AttemptAnswerAPIRequest extends APIRequest
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
        $rules = AttemptAnswer::$rules;
        return $rules;
    }


}
