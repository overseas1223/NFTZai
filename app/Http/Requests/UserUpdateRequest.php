<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'country_code' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'gender' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name' => __('First name can not be empty!'),
            'last_name' => __('Last name can not be empty!'),
            'country_code' => __('Country code can not be empty!'),
            'phone' => __('Phone can not be empty!'),
            'country' => __('Country can not be empty!'),
            'gender' => __('Gender can not be empty!'),
        ];
    }
}
