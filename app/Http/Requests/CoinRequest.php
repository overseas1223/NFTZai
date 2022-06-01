<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoinRequest extends FormRequest
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
        $rules =[
            'coin_full_name'=>'required|max:30',
        ];
        if(!empty($this->minimum_buy_amount)){
            $rules['minimum_buy_amount']='min:0.00000010';
        }

        if(!empty($this->coin_id)){
            $coin_id = decryptId($this->coin_id);
            $rules['ctype'] = 'required|unique:coins,coin_type,'.$coin_id.'|max:10';
        }else{
            $rules['ctype'] = 'required|unique:coins,coin_type|max:10';
        }

        return $rules;
    }

    public function messages()
    {
        $messages=[
            'ctype.required'=>'coin short name cant be empty',
            'ctype.unique'=>'coin short name already exists',
            'ctype.max'=>'coin short name cant be more than 10 character',
            'coin_full_name.required'=>'coin full name cant be empty',
            'coin_full_name.max'=>'coin full name cant be more than 30 character',
            'coin_icon.required'=>'coin icon can not be empty',
            'coin_icon.image'=>'coin icon must be image',
            'coin_icon.max'=>'coin icon should not be more than 2MB',
        ];
        if(!empty($this->minimum_buy_amount)){
            $messages['minimum_buy_amount.min']= 'minimum buy amount cant be less than 0.00000010';
        }
        return $messages;
    }
}
