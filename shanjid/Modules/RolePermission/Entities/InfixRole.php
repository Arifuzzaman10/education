<?php

namespace Modules\RolePermission\Entities;
use Illuminate\Database\Eloquent\Model;

class InfixRole extends Model
{
    protected $fillable = [];
    protected $casts = [
        ' saas_schools' => 'array',
    ];   
}
