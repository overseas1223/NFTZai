<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ResetPasswordRequest extends FormRequest
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
            'password' => 'required',
            'new_password' => [
                'required',
                env('APP_ENV')  == 'production' ? 'strong_pass' : '',
                env('APP_ENV')  == 'production' ? 'min:8' : '',
            ],
            'confirm_new_password' => 'required|same:new_password',
        ];
    }

    public function messages()
    {
        $messages = [
            'password.required' => __('Current password field can not be empty'),
            'new_password.required' => __('New password field can not be empty'),
            'confirm_new_password.required' => __('Confirm new password field can not be empty'),
            'new_password.min' => __('New password length must be minimum 8 characters.'),
            'new_password.strong_pass' => __('New password must be consist of one uppercase, one lowercase and one number!'),
            'confirm_new_password.same' => __('New password and confirm password does not match'),

        ];

        return $messages;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->header('accept') == "application/json") {
            $errors = [];
            if ($validator->fails()) {
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
            }
            $json = ['success' => false,
                'data' => [],
                'message' => $errors[0],
            ];
            $response = new JsonResponse($json, 200);

            throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
        } else {
            throw (new ValidationException($validator))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl());
        }
    }
}
