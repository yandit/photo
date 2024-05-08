<?php

namespace Modules\Company\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = @$this->route('company')->id;
        $appends = [];
        return array_merge([            
            'name' => 'required|unique:companies,name,' . $id,
            'status' => 'required:in:enable,disable',
        ], $appends);
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
