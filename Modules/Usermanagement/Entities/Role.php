<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'name',
    	'slug',
    	'permissions'
    ];
}
