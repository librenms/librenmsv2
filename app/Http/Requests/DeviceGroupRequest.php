<?php

namespace App\Http\Requests;

class DeviceGroupRequest extends AdminOnlyRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $name = 'required|max:255';
        if ($this->isMethod('post')) {
            $name .= '|unique:device_groups';
        }

        return [
            'name'    => $name,
            'desc'    => 'max:255',
            'pattern' => 'required',
        ];
    }
}
