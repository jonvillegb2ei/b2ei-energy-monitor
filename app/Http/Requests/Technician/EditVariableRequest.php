<?php

namespace App\Http\Requests\Technician;

use Illuminate\Foundation\Http\FormRequest;

class EditVariableRequest extends FormRequest
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
            'log_expiration' => 'required|numeric|min:0|max:'.pow(10,8),
            'log_interval' => 'required|numeric|min:0|max:'.pow(10,8)
        ];
    }
}
