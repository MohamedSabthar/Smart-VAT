<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubLicenceTaxReportRequest extends FormRequest
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
    public function rules()      //Validate the start Date and the end date of the report submission.
    {
        return [
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate']
        ];
    }
}
