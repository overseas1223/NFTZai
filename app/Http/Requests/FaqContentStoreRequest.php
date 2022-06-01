<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqContentStoreRequest extends FormRequest
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
            'question' => 'required',
            'answer' => 'required',
            'fh_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'question.required' => __('Question can not be null!'),
            'answer.required' => __('Answer can not be null!'),
            'fh_id.required' => __('Heading can not be null!'),
        ];
    }
}
