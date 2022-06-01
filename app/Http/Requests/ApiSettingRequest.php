<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApiSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'api_service.*' => 'required',
            'coin_id.*' => 'required',
            'withdrawal_fee_method.*' => 'required|numeric|between:1,3',
            'withdrawal_fee_percent.*' => 'required|numeric|between:0.00000000,99999999999.99999999',
            'withdrawal_fee_fixed.*' => 'required|numeric|between:0.00000000,99999999999.99999999',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'api_service.required' => 'api.service.is.required',
            'coin_id.required' => 'invalid.coin',
            'withdrawal_fee_method.required' => 'invalid.fee.method',
            'withdrawal_fee_method.numeric' => 'invalid.fee.method',
            'withdrawal_fee_method.between' => 'invalid.fee.method',
            'withdrawal_fee_percent.required' => 'invalid.fee.percent',
            'withdrawal_fee_percent.numeric' => 'invalid.fee.percent',
            'withdrawal_fee_percent.between' => 'invalid.fee.percent',
            'withdrawal_fee_fixed.required' => 'invalid.fee.fixed',
            'withdrawal_fee_fixed.numeric' => 'invalid.fee.fixed',
            'withdrawal_fee_fixed.between' => 'invalid.fee.fixed',
        ];
    }
}
