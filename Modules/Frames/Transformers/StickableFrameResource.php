<?php

namespace Modules\Frames\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class StickableFrameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'class' => $this->class,
            'image' => Storage::url($this->image),
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s'),
        ];
    }
}
