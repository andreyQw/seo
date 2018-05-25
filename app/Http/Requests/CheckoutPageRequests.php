<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutPageRequests extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'card_number' => 'required',
            'cvc' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'A field is required',
            'cvc.required' => 'A field is required',
//            'url.*.required' => 'A URL is required',
        ];
    }
}
