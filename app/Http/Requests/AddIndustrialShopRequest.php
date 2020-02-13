<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddIndustrialShopRequest extends FormRequest
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
        return[
            'assesmentNo' =>['required', 'string', 'max:255',  Rule::unique('industrial_tax_shops', 'registration_no')],
            'annualAssesmentAmount' => ['required','numeric'],
            'businessName' => ['required','string','max:255'],
            'phoneno' =>  ['required','regex:/[+94|0][0-9]{9}$/','min:10','max:12'],
            'doorno' => ['required','string','max:255'],
            'street' => ['required','string','max:255'],
            'city' => ['required','string','max:255'],
            'type' =>['required'],
            
        ];
    }
}