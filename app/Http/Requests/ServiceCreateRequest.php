<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceCreateRequest extends FormRequest
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
            'type' => 'required',
            'description' => 'required',
            'title' => 'required',
            'category_id' => 'required',
            'price_dollar' => [
                'required'
            ],
            'available_item' => [
                'required'
            ],
            'color' => 'required',
            'origin' => 'required',
//            'mint_address' => 'required',
            'expired_date' => 'required',
            'expired_time' => 'required',
            'thumbnail' => [
                'required',
                'mimes:jpg,png,gif,webp'
            ]
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'type.required' => __('Type can\'t be null'),
            'title.required' => __('Title can\'t be empty'),
            'category_id.required' => __('Category can\'t be empty'),
            'price_dollar.required' => __('Price can\'t be empty'),
            'available_item.required' => __('Available item can\'t be empty'),
            'color.required' => __('Color can\'t be empty'),
            'origin.required' => __('Origin can\'t be empty'),
            'expired_date.required' => __('Expiary date can\'t be empty'),
            'expired_time.required' => __('Expiary time can\'t be empty'),
            'thumbnail.required' => __('Thumbnail can\'t be empty'),
            'thumbnail.mimes' => __('Thumbnail file is not allowed'),
        ];
    }
}
