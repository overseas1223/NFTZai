<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCreateUser extends FormRequest
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
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return  [
            'first_name' => __('First name can not be empty'),
            'phone.required' => __('Phone number name can not be empty'),
            'phone.numeric' => __('Please enter a valid phone number'),
            'last_name' => __('Last name can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password_confirmation.required' => __('Confirm Password field can not be empty'),
            'password.min' => __('Password length must be atleast 8 characters.'),
            'password.regex' => __('Password must be consist of one uppercase, one lowercase and one number.'),
            'password_confirmation.min' => __('Confirm Password length must be atleast 8 characters.'),
            'password_confirmation.same' => __('New password and confirm password password does not match'),
            'email.required' => __('Email field can not be empty'),
            'email.unique' => __('Email Address already exists'),
            'email.email' => __('Invalid email address')
        ];
    }
}
