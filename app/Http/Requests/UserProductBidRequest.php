<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProductBidRequest extends FormRequest
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
            'wallet_id' => 'required',
            'price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'wallet_id.required' => __('Select a coin. Coin can not empty!'),
            'price.required' => __('Bid Price can not empty!'),
        ];
    }
}
