<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class AddLandRequest extends FormRequest
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
            'assesmentNo' =>['required','string', 'max:255', Rule::unique('land_taxes', 'registration_no')],
            'assesmentAmount' => ['required','numeric'],
            'landName' => ['required','string', 'max:255'],
            'phoneNo' => ['required', 'regex:/[+94|0][0-9]{9}$/','min:10','max:12'],
            'doorNo' => ['required','string','max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required','string','max:255'],

        ];
    }
}
