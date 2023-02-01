<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixRole;
use Modules\RolePermission\Entities\InfixPermissionAssign;

class UserRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $assignId = null)
    {

     
       if (!Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        $permissions =   app('permission');

        if(!$this->hasPermission($assignId)){
            abort(403);
        }

        if( (! is_null($permissions)) &&  (Auth::user()->role_id != 1) ){
            if( in_array($assignId , $permissions )){
                return $next($request);
            }
            else{
                abort('403');
            }
        }

        else{
            return $next($request);
        }
    }

    public function hasPermission($module_id){

        $module_ids = getPlanPermissionMenuModuleId();

        $permissions = InfixModuleInfo::where('parent_id', 0)->with(['children' ])->whereIn('id', $module_ids)->get();

        $parent_module = $permissions->where('id', $module_id)->first();

        if(!$parent_module){
            foreach($permissions as $permission){
                $children_module = $permission->children->where('id', $module_id)->first();
                if($children_module){
                    $parent_module = $permission;
                    break;
                }
            }
        }

        if($parent_module){
            $parent_module_id = $parent_module->id;

            // get permission name

            $school_permissions = planPermissions('menus', true);
            $key = false;
            foreach($school_permissions as $permission => $id){
                if($id == $parent_module_id){
                    $key = $permission;
                    break;
                }
            }

            if($key) {
                return isMenuAllowToShow($key);
            }
        }
    return true;
    }
}