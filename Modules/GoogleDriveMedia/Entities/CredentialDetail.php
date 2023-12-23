<?php

namespace Modules\GoogleDriveMedia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CredentialDetail extends Model
{

    protected $fillable = [
        'credential_id',
        'disk_id',
        'is_active'
    ];

    public function disk()
    {
        return $this->belongsTo(Disk::class);
    }
}
