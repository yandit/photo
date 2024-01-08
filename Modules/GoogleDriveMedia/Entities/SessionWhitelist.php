<?php

namespace Modules\GoogleDriveMedia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionWhitelist extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\GoogleDriveMedia\Database\factories\SessionWhitelistFactory::new();
    }
}
