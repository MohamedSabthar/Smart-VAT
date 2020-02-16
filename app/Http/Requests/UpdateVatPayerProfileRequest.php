<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVATpayerProfileRequest extends FormRequest
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
            // "full_name" and address instead
            'first_name' => ['required', 'string', 'max:255', Rule::unique('vat_payers')->ignore($this->id)],
            'middle_name' => ['required', 'string', 'max:255', Rule::unique('vat_payers')->ignore($this->id)],
            'last_name' => ['required', 'string', 'max:255',Rule::unique('vat_payers')->ignore($this->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('vat_payers')->ignore($this->id)],            //   Validate to be a unique email
            'nic' => ['required','string','regex:/[0-9]{9}([x|X|v|V]$|[0-9]{3}$)/',Rule::unique('vat_payers')->ignore($this->id)],     //   validation for nic
            'phone' => ['required','regex:/[+94|0][0-9]{9}$/','min:10','max:12'],
            'doorNo' =>['required','numeric','max:100'],
            'street'=>['required', 'string', 'max:255'],
            'city'  =>['required', 'string', 'max:255'],
            
        ];
    }
}