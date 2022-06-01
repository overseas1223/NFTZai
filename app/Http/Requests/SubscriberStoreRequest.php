<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberStoreRequest extends FormRequest
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
            'email_address' => 'required|email|unique:subscribers,email_address',
        ];
    }

    public function messages()
    {
        return [
            'email_address.email' => __('Invalid email address.'),
            'email_address.unique' => __('You are already subscribed.')
        ];
    }
}
