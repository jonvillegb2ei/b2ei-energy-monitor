<?php

namespace App\Http\Requests\Equipments;

use Illuminate\Foundation\Http\FormRequest;

class ChartDataRequest extends FormRequest
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
            'variables' => 'required|array|min:1',
            'variables.*' => 'exists:variables,id',
            'date.startDate' => 'nullable|string|min:0|max:150',
            'date.endDate' => 'nullable|string|min:0|max:150',
        ];
    }
}
