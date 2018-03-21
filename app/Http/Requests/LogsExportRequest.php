<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogsExportRequest extends FormRequest
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
            'start' => 'nullable|string|min:0|max:150',
            'end' => 'nullable|string|min:0|max:150',
        ];
    }
}
