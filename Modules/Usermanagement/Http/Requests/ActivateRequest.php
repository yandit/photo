<?php

namespace Modules\UserManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivateRequest extends FormRequest
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
            'password' => 'required|min:6|regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.{1,})(?=.*[0-9]).*$/|confirmed',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
