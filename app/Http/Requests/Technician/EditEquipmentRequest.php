<?php

namespace App\Http\Requests\Technician;

use Illuminate\Foundation\Http\FormRequest;

class EditEquipmentRequest extends FormRequest
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
            'localisation' => 'nullable|string|min:0|max:250',
            'name' => 'nullable|string|min:0|max:250',
            'address_ip' => 'required|ip',
            'port' => 'required|numeric|min:1|max:65535',
            'slave' => 'required|numeric|min:0|max:255',
        ];
    }
}
