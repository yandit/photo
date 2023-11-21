<?php

namespace Modules\UserManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $appends = [];   
        if(!empty($this->input('password')) && !empty($this->input('repeat_password'))){
            if($this->password === $this->repeat_password){
                $appends['password'] = 'required|min:8';
            }
        }
        return [            
            'name' => 'required|min:2|max:190',
        ] + $appends;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
