<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequestValidation extends FormRequest
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
            'place_of_delivery_id' => 'bail|required|numeric|min:1|exists:place_of_deliveries,id',
            'full_name' => 'required|string',
            'phone_number' => 'string',
            'default_distance' => 'numeric|min:0',
        ];
    }
}
