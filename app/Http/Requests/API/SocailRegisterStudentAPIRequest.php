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
            'password' => 'nullable',
            'email' => 'nullable|unique:students',
            'photo' => 'nullable|file',
            'phone' => 'nullable|unique:students',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'date_of_birth' => 'nullable|data_format:Y-m-d',
            'username' => 'nullable|unique:students',
            'governorate' => 'nullable',
            'area' => 'nullable',
            'residence_area' => 'nullable',
            'specialization' => 'nullable',
            'provider_id' => 'required',
            'provider_type' => 'required',
            'device_token' => 'nullable',
        ];
    }


    /**
     * Customize error messages for specific fields (optional).
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل', // "Email is already in use"
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل', // "Phone number is already in use"
            'username.unique' => 'اسم المستخدم مستخدم بالفعل', // "Email is already in use"

            'academic_year_id.exists' => 'معرف السنة الدراسية غير صالح', // "Invalid academic year ID"
            'date_of_birth.date_format' => 'تنسيق تاريخ الميلاد غير صالح (YYYY-MM-DD)', // "Invalid date format for date_of_birth (YYYY-MM-DD)"
            'required' => 'الحقل مطلوب', // "The field is required"
            'file' => 'يجب أن يكون ملفًا (للصورة)', // "Must be a file (for photo)"
        ];
    }


}
