<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRentProfileRequest extends FormRequest
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
        
            'businessName' => ['required','alpha', 'string', 'max:255', Rule::unique('Shop_rent_tax','shop_name')->ignore($this->id)],
            'monthAssesmentAmount' => ['required','numeric'],
            'doorno' =>['required','numeric','max:100'],                              
            'street'=>['required','alpha', 'string', 'max:255'],
            'city'  =>['required','alpha', 'string', 'max:255'],
            'phoneno' => ['required','regex:/[+94|0][0-9]{9}$/','min:10','max:12'],
        ];
    }
}
