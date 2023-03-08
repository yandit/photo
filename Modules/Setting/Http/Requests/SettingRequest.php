<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Setting\Entities\SettingModel;

class SettingRequest extends FormRequest
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
        $id = $this->route('id');
        $group = $this->input('group');        
        $appends = [];
        
        return array_merge([
            'key' => [
                'required',
                'max:190',
                function ($attribute, $value, $fail) use($group) {
                    $key = strtolower(str_replace(' ', '_', $group)).'.'.$value;
                    $setting = SettingModel::where('key',$key)->first();
                    if ($setting) {
                        $fail($attribute.' already exists.');
                    }
                },
            ],
            'name' => 'required|max:250',
            'type' => 'required|max:190',
            'group' => 'required|max:190',
        ], $appends);
    }

}
