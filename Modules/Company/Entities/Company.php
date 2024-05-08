<?php

namespace Modules\Company\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\Entities\User;

class Company extends Model
{
    protected $fillable = [
        'name',
        'status',
        'created_by_id',
        'updated_by_id'
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
}
