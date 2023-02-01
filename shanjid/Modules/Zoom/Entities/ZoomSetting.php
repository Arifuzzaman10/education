<?php

namespace Modules\Zoom\Entities;

use Illuminate\Database\Eloquent\Model;

class ZoomSetting extends Model
{
    protected $guarded = ['id'];
    protected $table = 'zoom_settings';
}
