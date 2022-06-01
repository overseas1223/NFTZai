<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
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
            'password' =>[
                'required',
                env('APP_ENV')  == 'production' ? 'strong_pass' : '',
                env('APP_ENV')  == 'production' ? 'min:8' : '',            // must be at least 8 characters in length
                env('APP_ENV')  == 'production' ? 'regex:/[a-z]/' : '',      // must contain at least one lowercase letter
                env('APP_ENV')  == 'production' ? 'regex:/[A-Z]/' : '',      // must contain at least one uppercase letter
                env('APP_ENV')  == 'production' ? 'regex:/[0-9]/' : '',      // must contain at least one digit
            ],
            'password_confirmation' => 'required|min:8|same:password',
        ];
    }

    public function messages()
    {
        return  [
            'first_name' => __('First name can not be empty'),
            'phone.required' => __('Phone number name can not be empty'),
            'phone.numeric' => __('Please enter a valid phone number'),
            'last_name' => __('Last name can not be empty'),
            'device_token.required' => __('Device token field can not be empty'),
            'device_type.required' => __('device type field can not be empty'),
            'password.required' => __('Password field can not be empty'),
            'password_confirmation.required' => __('Confirm Password field can not be empty'),
            'password.min' => __('Password length must be atleast 8 characters.'),
            'password.regex' => __('Password must be consist of one uppercase, one lowercase and one number.'),
            'password.strong_pass' => __('Password must be consist of one uppercase, one lowercase and one number.'),
            'password_confirmation.min' => __('Confirm Password length must be atleast 8 characters.'),
            'password_confirmation.same' => __('Password and confirm password doesn\'t match'),
            'email.required' => __('Email field can not be empty'),
            'email.unique' => __('Email Address already exists'),
            'email.email' => __('Invalid email address')
        ];
    }
}
