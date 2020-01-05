<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PositiveValue; //custom validation rules

class UpdateBusinessTypeRequest extends FormRequest
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
