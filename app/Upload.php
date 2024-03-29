<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
