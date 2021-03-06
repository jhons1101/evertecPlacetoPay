<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            "product_id"     => "required",
            "customer_name"  => "required|string|min:5|max:80",
            "customer_email" => "required|email|min:10|max:120",
            "customer_phone" => "required|numeric|digits:10"

        ];
    }
}
