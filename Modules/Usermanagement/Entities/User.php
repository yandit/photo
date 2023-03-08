<?php

namespace Modules\UserManagement\Entities;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends EloquentUser implements AuthenticatableContract
{
    use Authenticatable;
    protected $fillable = [
        'email',
        'password',        
        'permissions',
        'last_login',
        'first_name',
        'last_name',

        'name',
        'phone',
        'address',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login'
    ];

    public function role()
    {
        return $this->hasOneThrough(Role::class, RoleUser::class, 'role_id','id');
    }


    public function scopeAdminUser($query){
        $query
            ->select('users.*','activations.completed')
            ->join('role_users', 'role_users.user_id', 'users.id')
            ->join('roles', 'roles.id', 'role_users.role_id')
            ->join('activations', 'activations.user_id', 'users.id');
            // ->whereNotIn('roles.slug', config('user.public'));
        return $query;
    }
    
}
