<?php

namespace Modules\GoogleDriveMedia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Credential extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'path',
        'created_by_id',
        'updated_by_id'
    ];
    
    protected static function newFactory()
    {
        return \Modules\GoogleDriveMedia\Database\factories\CredentialFactory::new();
    }
}
