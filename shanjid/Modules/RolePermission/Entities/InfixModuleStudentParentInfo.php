<?php

namespace Modules\RolePermission\Entities;

use Illuminate\Database\Eloquent\Model;

class InfixModuleStudentParentInfo extends Model
{
    protected $fillable = [];
    public static function studentMenu($id){
        return InfixModuleStudentParentInfo::where('parent_id',$id)
        ->whereNotIn('parent_id',[1,11,56,66])
        ->whereNotIn('name',['edit','view','edit','add','add content'])
        ->where('active_status',1)->get();
    }
    public static function studentMenuAll($parent_id,$child_id){
      return  $result=array_merge($parent_id,$child_id);


    }
}
