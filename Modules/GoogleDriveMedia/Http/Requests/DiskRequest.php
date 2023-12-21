<?php

namespace Modules\GoogleDriveMedia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = @$this->route('disk')->id;
        $appends = [];
        return array_merge([            
            'disk_name' => 'required|unique:disks,disk_name,'.$id,
            'client_id' => 'required|unique:disks,client_id,'.$id,
            'client_secret' => 'required|unique:disks,client_secret,'.$id,
            'refresh_token' => 'required|unique:disks,refresh_token,'.$id,
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
