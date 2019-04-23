<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequestValidation extends FormRequest
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
            'order_system_number' => 'required',
            'client_id' => 'required|exists:clients,id',
            'advance' => 'numeric|min:0',
            'distance' => 'numeric|min:0|max:1000',
            'percentage_discount' => 'numeric|min:0|max:100',
            'total_penny_order_sum' => 'numeric|min:0',
            'created_at' => 'required|date_format:Y-m-d',
            'deadline_at' => 'required|date_format:Y-m-d',
        ];
    }
}
