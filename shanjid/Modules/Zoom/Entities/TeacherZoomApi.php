<?php

namespace Modules\Zoom\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherZoomApi extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Zoom\Database\factories\TeacherZoomApiFactory::new();
    }
}
