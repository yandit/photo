<?php

namespace Modules\GoogleDriveMedia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CredentialRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = @$this->route('customer')->credential->id;
        $appends = [];
        return array_merge([            
            'path' => 'required|unique:credentials,path,'.$id,
            'pin' => 'required|digits:6'
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
