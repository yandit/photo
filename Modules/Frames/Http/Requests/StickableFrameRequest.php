<?php

namespace Modules\Frames\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StickableFrameRequest extends FormRequest
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
        $appends = [];
        if($id){
            $appends = 
            [
                'image' => 'max:3000|mimetypes:image/jpeg,image/png,image/jpg',
                'slug' => "required|max:190|unique:frames_stickables,slug,{$id},id,deleted_at,NULL",
            ];
            

        }
        return array_merge([
            'title' => 'required|max:190',            
            'slug' => 'required|max:190|unique:frames_stickables,slug,NULL,id,deleted_at,NULL',
            'class' => 'required|max:190',
            'order' => 'required|integer',
            'image' => 'required|max:3000|mimetypes:image/jpeg,image/png,image/jpg',
            'status' => 'required|in:draft,publish',
        ], $appends);
    }
}
