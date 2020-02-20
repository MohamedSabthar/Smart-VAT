<?php

namespace App\Http\Requests;

use App\Rules\PositiveValue; //custom validation rules

use Illuminate\Foundation\Http\FormRequest;

class UpdateLicenseTypeRequest extends FormRequest
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
            "updateId" => ["required"],
            "updatedDescription"  => ['required','string'],
            "updatedAmount" => ['required','numeric',new PositiveValue],
        ];
    }
}