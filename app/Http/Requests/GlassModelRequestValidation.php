<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GlassModelRequestValidation extends FormRequest
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
            'material_type_id' => 'bail|required|numeric|min:1|exists:material_types,id',
            'material_id' => 'bail|required|numeric|min:1|exists:materials,id',
            'name' => 'required|string',
            'thickness' => 'numeric|min:1',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:0',
        ];
    }
}
