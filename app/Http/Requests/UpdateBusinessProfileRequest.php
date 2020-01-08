<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessProfileRequest extends FormRequest
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
            'shop_name' => ['required','alpha', 'string', 'max:255', Rule::unique('vat_payers')->ignore($this->id)],
            'anual_worth' => ['required'],
            'door_no' =>['required','numeric','max:100'],                              
            'street'=>['required','alpha', 'string', 'max:255'],
            'city'  =>['required','alpha_num', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('vat_payers')->ignore($this->id)],            //   Validate to be a unique email
            'nic' => ['required','string','regex:/[0-9]{9}([x|X|v|V]$|[0-9]{3}$)/',Rule::unique('vat_payers')->ignore($this->id)],     //   validation for nic
            'phone' => ['required','regex:/[+94|0][0-9]{9}$/','min:10','max:12'],
        ];
    }
}
