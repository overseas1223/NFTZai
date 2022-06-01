<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class WithdrawalLimitRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->role == 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'from' => 'required|numeric',
            'to' => 'required|numeric',
            'adminapproval' => 'required|integer|min:0|max:1',
        ];
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'from.required' => __('From field can not be empty'),
            'to.required' => __('To field can not be empty'),
            'from.numeric' => __('From field must be a number'),
            'to.numeric' => __('To field must be a number'),
            'adminapproval.integer' => __('Invalid Admin Approval'),
            'adminapproval.min' => __('Invalid  Admin Approval'),
            'adminapproval.max' => __('Invalid Admin Approval')
        ];
    }
}
