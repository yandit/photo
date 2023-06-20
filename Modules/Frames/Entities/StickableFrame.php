<?php

namespace Modules\Frames\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Modules\UserManagement\Entities\User;

class StickableFrame extends Model
{
    use SoftDeletes;
    
    protected $table = 'frames_stickables';
    protected $fillable = [    	        
        'title',
        'slug',
        'class',
        'image',
        'order',        
        'status',
        'created_by_id',
        'updated_by_id'
    ];

    public function delete()
	{
        if($this->image){
            Storage::delete($this->image_mobile);
        }
        
	    parent::delete();
	}

    public function scopePublished($query)
    {
        return $query->where('status', 'publish');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
}
