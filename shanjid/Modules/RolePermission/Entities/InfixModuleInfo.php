<?php

namespace Modules\RolePermission\Entities;

use Illuminate\Database\Eloquent\Model;

class InfixModuleInfo extends Model
{
    protected $fillable = ['*'];

    public function subModule(){
        
        return $this->hasMany('Modules\RolePermission\Entities\InfixModuleInfo','parent_id','id')->where('active_status', 1);
    }

    public function children(){
        return $this->hasMany('Modules\RolePermission\Entities\InfixModuleInfo','parent_id','id');
    }

    public function allGroupModule(){
        return $this->subModule()->where('id','!=',$this->module_id);
    }
}
