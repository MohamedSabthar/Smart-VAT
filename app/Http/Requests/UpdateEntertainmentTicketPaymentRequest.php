<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\PositiveValue; //custom validation rules

class UpdateEntertainmentTicketPaymentRequest extends FormRequest
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
            "paymentId" => ['required'],
            "updateTicketType" => ['required'],
            "updatePlaceAddress" => ['required'],
            "updateQuotedTickets" => ['required','numeric',new PositiveValue,],
            "updateTicketPrice" => ['required','numeric',new PositiveValue],
            "updateReturnedTickets" => ['required','numeric',new PositiveValue,'lte:updateQuotedTickets'],
        ];
    }
}