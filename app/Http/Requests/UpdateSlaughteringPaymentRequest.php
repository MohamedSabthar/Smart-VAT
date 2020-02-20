<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PositiveValue;

class UpdateSlaughteringPaymentRequest extends FormRequest

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
            "updateslaughteringType" => ['required'],
            "updateAnimalCount" => ['required','numeric',new PositiveValue],
        ];
    }
}
