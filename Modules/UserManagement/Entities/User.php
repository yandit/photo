<?php

namespace Modules\UserManagement\Entities;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Modules\Company\Entities\Company;

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
        'created_by_id',
        'updated_by_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'last_login'
    ];

    public function role()
    {
        return $this->hasOneThrough(Role::class, RoleUser::class, 'user_id','id','id','role_id');
    }


    public function scopeAdminUser($query){
        $query
            ->select('users.*','activations.completed')
            ->join('role_users', 'role_users.user_id', 'users.id')
            ->join('roles', 'roles.id', 'role_users.role_id')
            ->join('activations', 'activations.user_id', 'users.id')
            ->whereIn('roles.name', ['admin']);
        return $query;
    }
    
    public function created_by()
    {
        return $this->belongsTo(self::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }
}
