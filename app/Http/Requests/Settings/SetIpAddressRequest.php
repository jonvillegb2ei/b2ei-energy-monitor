<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SetIpAddressRequest extends FormRequest
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
            'address_ip' => 'nullable|ip',
            'netmask' => 'nullable|ip',
            'gateway' => 'nullable|ip',
            'dns' => 'nullable|string',
            'dhcp-checkbox' => 'nullable|in:on,1,0,off',
            'static-checkbox' => 'nullable|in:on,1,0,off',
        ];
    }
}
