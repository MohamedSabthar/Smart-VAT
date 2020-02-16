<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['required','alpha', 'string', 'max:255'],
            'userName' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($this->id)],   // username should be unique exclude current user
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->id)],    //unique exclude current user
            'phone' => ['required','regex:/[+94|0][0-9]{9}$/','min:10','max:12'],
        ];
    }
}