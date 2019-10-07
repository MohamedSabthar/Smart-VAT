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
            'annualAssesmentAmount' => ['required','string', 'max:255'],  
            'businessName' => ['required', 'alpha','string','max:255'], 
            'phoneno' => ['required','alpha','string','max:255'],    
            'doorno' => ['required','alpha','string','max:255'],  
            'street' => ['required','alpha','string','max:255'],  
            'city' => ['required','alpha','string','max:255'],     
            
        ];
    }
}
