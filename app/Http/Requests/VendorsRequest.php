<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorsRequest extends FormRequest
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
            'logo'=>'required_without:id|mimes:jpg,jpeg,png',
            'name'=>'required|string|max:150',
            'mobile'=>'required|max:100|unique:vendors,mobile,'.$this -> id,
            'email'=>'required|email|unique:vendors,email,'.$this -> id,
            'category_id' => 'required|exists:main_categories,id',
            'address'=>'required|string|max:191',
            'password'=>'required_without:id',

        ];
    }


    public function messages(){
        return $messages = [
            'required_without' => ' الصورة مطلوبة',
            'required' => 'هذا الحقل مطلوب',
            'email.unique' => 'البريد هذا مستخدم من قبل',
            'mobile.unique' => 'رقم الهاتف هذا مستخدم من قبل',
            'string' => 'هذا الحقل لابد ان يكون حروف و أرقام',
            'name.max' => 'هذا الحقل لابد الا يزيد عن 150 حرف ',
            'email.max' => 'هذا الحقل لابد الا يزيد عن 180 حرف ',
            'address.max' => 'هذا الحقل  لابد الا يزيد عن 180 حرف ',
            'email.email' => 'أدخل عنوان بريد الكتروني صالح',
            'category_id.exists' => 'القسم غير موجود',
            'password'=>'لا تحقق الشروط'
        ];
    }
}
