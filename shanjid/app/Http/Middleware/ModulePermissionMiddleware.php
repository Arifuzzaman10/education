<?php

namespace App\Http\Middleware;

use Closure;
use App\SmModulePermission;
use App\Models\SchoolModule;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class ModulePermissionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module)
    {
      
        $user = Auth::user();
        if ($user->school_id == 1) {
            return $next($request);
        }

        if ($user) {
            $check_active = SchoolModule::where('module_name', $module)->where('school_id', auth()->user()->school_id)->where('active_status', 1)->first();
            if (is_null($check_active)) {
                Toastr::error('Module Not Active', 'Failed');
                return redirect()->route('dashboard');
            } else {
                return $next($request);
            }
        }
       
        return redirect('login');
    }
}
