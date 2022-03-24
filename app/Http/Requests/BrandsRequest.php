<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandsRequest extends FormRequest
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
        ];
    }



    public function messages(){
        return $messages = [
            'required_without' => ' الصورة مطلوبة',
            'required' => 'هذا الحقل مطلوب',
            'string' => 'هذا الحقل لابد ان يكون حروف و أرقام',
            'name.max' => 'هذا الحقل لابد الا يزيد عن 150 حرف ',
        ];
    }

}
