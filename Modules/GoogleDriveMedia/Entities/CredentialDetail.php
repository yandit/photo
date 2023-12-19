<?php

namespace Modules\GoogleDriveMedia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CredentialDetail extends Model
{

    protected $fillable = [
        'credential_id',
        'client_id',
        'client_secret',
        'refresh_token',
        'disk_name',
        'is_active'
    ];
}
