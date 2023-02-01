<?php

namespace Modules\MenuManage\Entities;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;

class UserMenu extends Model
{
    use HasFactory;

    protected $fillable = []; 

    public function menuName(){
        return $this->belongsTo('Modules\MenuManage\Entities\Sidebar','parent_id','infix_module_id');
    }
    public static function childMenu($id){
        $user=Auth::user();
        return UserMenu::where('parent_id',$id)
                        ->where('module_id','!=',$id)
                        ->where('active_status',1)
                        ->where('user_id',$user->id)
                        ->where('role_id',$user->role_id)
                        ->orderBy('id', 'ASC')                        
                        ->get();
    }
    public function childMenuName(){
       return $this->belongsTo('Modules\MenuManage\Entities\Sidebar','module_id','infix_module_id');
   }

   public  function subModule(){
        return $this->belongsTo('Modules\RolePermission\Entities\InfixModuleInfo','module_id','id');

   }


   public static  function studentParent($id){
     if(Auth::user()->role_id==2){
      $user_type=1;
     }elseif(Auth::user()->role_id==3){
      $user_type=2;
     }
    
     return InfixModuleStudentParentInfo::where('module_id',$id)->where('user_type',$user_type)->first();

   }

   public static  function studentParentSubMenu($id){
    if(Auth::user()->role_id==2){
      $user_type=1;
     }elseif(Auth::user()->role_id==3){
      $user_type=2;
     }
    return InfixModuleStudentParentInfo::where('id',$id)->where('user_type',$user_type)->first();

  }
  public static function preAssignChild($parent_id){
      if(Auth::user()->role_id==2){
      $user_type=1;
     }elseif(Auth::user()->role_id==3){
      $user_type=2;
     }
    return InfixModuleStudentParentInfo::where('parent_id',$parent_id)->where('route','!=','')->where('module_id','!=',1)->where('user_type',$user_type)->get();
  }
  
}
