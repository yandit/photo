<?php

namespace Modules\GoogleDriveMedia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UserManagement\Entities\User;
use Modules\Company\Entities\Company;

class Disk extends Model
{

    protected $fillable = [
        'client_id',
        'email',
        'password',
        'company_id',
        'type',
        'client_secret',
        'refresh_token',
        'disk_name',
        'created_by_id',
        'updated_by_id'
    ];

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
