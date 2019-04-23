<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HoleRequestValidation extends FormRequest
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
            'glass_pane_id' => 'bail|required|numeric|min:1|exists:glass_panes,id',
            'number' => 'required|numeric|min:0',
            'unit' => 'required|string',
            'price' => 'required|numeric|min:0',
        ];
    }
}
