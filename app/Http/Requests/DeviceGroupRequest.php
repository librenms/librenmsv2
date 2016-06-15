<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class DeviceGroupRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required|max:255',
            'desc'    => 'max:255',
            'pattern' => ['required', 'regex:/^[A-Za-z0-9\.\|&@~" _%=<>]+$/'],
        ];
    }
}
