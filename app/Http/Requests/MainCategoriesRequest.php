<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoriesRequest extends FormRequest
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
           'photo'=>'required_without:id|mimes:jpg,jpeg,png',
            'category'=>'required|array|min:1',
            'category.*.name'=>'required',
            'category.*.abbr'=>'required',
            //'category.*.active'=>'required',
        //    'name'=>'required |string|max:150',
          //  'abbr'=>'required |string|max:10',


        ];
    }


    public function messages(){
        return $messages = [
            'required' => 'هذا الحقل مطلوب',
            /*'in' => 'القيم المدخلة غير صحيحة ',
            'name.string' => 'اسم اللغة لابد ان يكون أحرف',
            'abbr.max' => 'هذا الحقل لابد الا يزيد عن 10 احرف ',
            'abbr.string' => 'هذا الحقل لابد ان يكون احرف ',
            'name.max' => 'اسم اللغة لابد الا يزيد عن 100 احرف ',*/
        ];
    }
}
