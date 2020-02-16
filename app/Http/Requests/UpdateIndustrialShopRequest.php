<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIndustrialShopRequest extends FormRequest
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
             'industrialName' => ['required', 'string', 'max:255', Rule::unique('business_tax_shops', 'shop_name')->ignore($this->id)],
             'anual_worth' => ['required','numeric'],
             'doorno' =>['required','string','max:100'],
             'street'=>['required', 'string', 'max:255'],
             'city'  =>['required', 'string', 'max:255'],
             'phoneno' => ['required','regex:/[+94|0][0-9]{9}$/','min:10','max:12'],
      
        ];
    }
}