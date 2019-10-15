<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class AddBusinessRequest extends FormRequest
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
            'assesmentNo' =>['required', 'string', 'max:255', 'unique:business_tax_shops,registration_no'],
            'annualAssesmentAmount' => ['required','numeric'],
            'businessName' => ['required','string','max:255'],
            'phoneno' => ['required','numeric','digits_between:10,10'],
            'doorno' => ['required','alpha_num','max:255'],
            'street' => ['required','alpha_num','max:255'],
            'city' => ['required','string','max:255'],
            'type' =>['required'],
            
        ];
    }
}