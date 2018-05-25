<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'numOfWeb' => 'required|integer',
            'url.*' => 'required',
            'quantity.*' => 'required|integer',
            'email' => 'required|email|max:255|unique:users,email',
//            'email' => 'required|email|max:255',
        ];
    }
    public function messages()
    {
        return [
            'numOfWeb.required' => 'A Number of WebSites is required',
            'url.*.required' => 'A URL is required',
        ];
    }
}
