<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PositiveValue;

class AddEntertainmentPerformanceTypeRequest extends FormRequest
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
            "description" => ['required','string','unique:entertainment_performance_types,description'],
            "amount" => ['required','numeric',new PositiveValue],
            'additionalAmmount' => ['required','numeric',new PositiveValue],
             
        ];
    }
}