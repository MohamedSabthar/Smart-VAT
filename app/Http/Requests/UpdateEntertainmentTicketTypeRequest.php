<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\VatPercentage; //custom validation rules

class UpdateEntertainmentTicketTypeRequest extends FormRequest
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
            "updateId" => ['required'],
            "updateDescription" => ['required','string'],
            "updatePercentage" => ['required','numeric',new VatPercentage],
        ];
    }
}