<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UserManagement\Entities\User;
use Modules\GoogleDriveMedia\Entities\Credential;

class Customer extends Model
{
    

    protected $fillable = [
        'name',
        'slug',
        'status',
        'created_by_id',
        'updated_by_id'
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }

    public function credential()
    {
        return $this->hasOne(Credential::class);
    }
    
}
