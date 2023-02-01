<?php

namespace Modules\MenuManage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
class MenuManage extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function menuName(){
        return $this->belongsTo('Modules\MenuManage\Entities\Sidebar','parent_id','infix_module_id');
    }
    public static function childMenu($id){
        $user=Auth::user();
        return MenuManage::where('parent_id',$id)
                        ->where('module_id','!=',$id)
                        ->where('active_status',1)
                        ->where('user_id',$user->id)
                        ->where('role_id',$user->role_id)
                        ->orderBy('id', 'ASC')
                        ->get();
    }
    public function childMenuName(){
       return $this->belongsTo('Modules\MenuManage\Entities\Sidebar','child_id','infix_module_id');
   }
   public  function subModule(){
        return $this->belongsTo('Modules\RolePermission\Entities\InfixModuleInfo','module_id','id');

   }
}
