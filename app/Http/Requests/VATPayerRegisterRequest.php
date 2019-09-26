<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VATPayerRegisterRequest extends FormRequest
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
            'f_name' => ['required','alpha', 'string', 'max:255', Rule::unique('vat_payers')->ignore($this->id)],
            'L_name' => ['required','alpha', 'string', 'max:255',Rule::unique('vat_payers')->ignore($this->id)],
            'doorNo' =>['required','alpha','varchar','max:100'],                              
            'street'=>['required','alpha', 'string', 'max:255'],
            'city'  =>['required','alpha', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('vat_payers')->ignore($this->id)],            //   Validate to be a unique email
            'nic' => ['required','string','regex:/[0-9]{9}([x|X|v|V]$|[0-9]{3}$)/',Rule::unique('vat_payers')->ignore($this->id)],     //   validation for nic
            'phone' => ['required','regex:/[+94|0][0-9]{9}$/'],
        ];
    }
}
