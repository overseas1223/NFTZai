<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class WithdrawalRequest extends FormRequest
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
        $rules = [
            'wallet_id' => 'required|integer|exists:wallets,id,user_id,' . Auth::id(),
            'address' => 'required',
            'amount' => 'required|numeric|between:0.00000001,99999999999.99999999',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'wallet_id.required' => __('Invalid withdrawal request!'),
            'wallet_id.integer' => __('Invalid withdrawal request!'),
            'wallet_id.exists' => __('Invalid withdrawal request!'),
            'address.required' => __('Crypto Coin Address is required!'),
            'amount.required' => __('Withdrawal Amount is required!'),
            'amount.numeric' => __('Withdrawal Amount value is invalid!'),
            'amount.between' => __('Withdrawal Min value: :min  and Max value: 99999999999!')
        ];
    }

    public function failedValidation(Validator $validator)
    {
            $errors = '';
            if ($validator->fails()) {
                $e = $validator->errors()->first();
                $errors = $e;
            }
            $json = [
                'status' => false,
                'message' => $errors,
            ];
            $response = new JsonResponse($json, 422);
            throw (new ValidationException($validator, $response))->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
    }
}
