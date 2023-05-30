<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\Entities\User;

class Role extends Model
{

    protected $fillable = [
        'name',
    	'slug',
    	'permissions',
        'created_by_id',
        'updated_by_id'
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
}
