<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Frames\Entities\StickableFrame;

class Cart extends Model
{
    protected $guarded = [];

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function frames_stickable()
    {
        return $this->belongsTo(StickableFrame::class);
    }
}
