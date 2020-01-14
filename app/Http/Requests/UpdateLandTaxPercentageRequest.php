<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

 //custom validation rules
use App\Rules\VatPercentage;

class UpdateLandTaxPercentageRequest extends FormRequest
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
            "vatPercentage" => ["required","numeric",new VatPercentage],
            "dueDate" => ["required"],
        ];
    }
}
