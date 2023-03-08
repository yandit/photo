<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Setting\Entities\SettingModel;

class SettingAllRequest extends FormRequest
{
    private $niceNames;

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
        $settings = SettingModel::get();
        $rules = [];
        $niceNames = [];

        foreach($settings as $setting){
            $rule = 'nullable';
            if($setting->type == 'image'){
                $rule .= '|max:3000|mimetypes:image/jpeg,image/png,image/jpg,image/gif';
            }
            $rules['settings.'.$setting->id] = $rule;
            $niceNames['settings.'.$setting->id] = 'input';
        }
        $this->niceNames = $niceNames;

        return $rules;
    }

    public function attributes()
    {
        return $this->niceNames;   
    }

}
