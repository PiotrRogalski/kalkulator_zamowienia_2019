<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequestValidation extends FormRequest
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
            'distance_km_price' => 'numeric|min:0',
            'free_delivery_from_price' => 'numeric|min:0',
            'free_delivery_distance' => 'numeric|min:0',
            'company_metadata' => 'string',
            'last_company_metadata' => 'string',
            'standard_order_time' => 'numeric|min:0',
            'time_of_order_limitation' => 'numeric|min:0',
            'printing_unit_glass_dimension' => 'string',
            'unit_glass_dimension' => 'string',
        ];
    }
}
