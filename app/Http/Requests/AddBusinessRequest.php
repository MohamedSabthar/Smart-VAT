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
        return [
            'assesmentNo' =>['required', 'string', 'max:255', Rule::unique('business_tax_shop')->ignore($this->id)], 
            'annualAssesmentAmount' => ['required','alpha', 'string', 'max:255'],  
            'businessName' => ['required', 'alpha','string', 'email', 'max:255'],    
            'businessAddress' => ['required','alpha','string','max:255'],     
            
        ];
    }
}
