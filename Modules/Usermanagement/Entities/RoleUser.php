<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_users';
    protected $fillable = [
        'role_id',
    ];
    protected $primaryKey = 'user_id';
}
