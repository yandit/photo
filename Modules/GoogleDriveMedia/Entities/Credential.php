<?php

namespace Modules\GoogleDriveMedia\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Entities\Customer;
use Modules\UserManagement\Entities\User;

class Credential extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'path',
        'created_by_id',
        'updated_by_id'
    ];

    public function credential_details()
    {
        return $this->hasMany(CredentialDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\GoogleDriveMedia\Database\factories\CredentialFactory::new();
    }
}
