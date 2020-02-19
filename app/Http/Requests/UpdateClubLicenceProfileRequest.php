<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClubLicenceProfileRequest extends FormRequest
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
        //dd($this->id);

        return [
        'assesmentNo' => ['required','string', 'max:255', Rule::unique('club_licence_tax_clubs', 'registration_no')->ignore($this->id)],
        'annualAssesmentAmount' => ['required','numeric'],
        'clubName' => ['required','string', 'max:255'],
        'phoneno' => ['required', 'regex:/[+94|0][0-9]{9}$/','min:10','max:12'],
        'doorno' => ['required','string','max:255'],
        'street' => ['required', 'string', 'max:255'],
        'city' => ['required','string','max:255'],
        ];
    }
}
