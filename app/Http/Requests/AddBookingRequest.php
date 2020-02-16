<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
           
            'bookingPlace' => ['required','string','max:255'],
            'event' => ['required','string','max:255'],
            'date' => ['required','string','max:255'],
            'keyMoney' =>['required','string','max:255'],
            'time' =>['required','string','max:255'],
            'addtTime' => ['required','string','max:255']
        ];
    }
}
