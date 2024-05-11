<?php

namespace Modules\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = @$this->route('customer')->id;
        $appends = [];
        if(!loggedInUser('company')){
            $appends = ['company' => 'required'];
        }
        return array_merge([            
            'name' => 'required|unique:customers,name,' . $id,
            'slug' => 'required|unique:customers,slug,' . $id,
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
