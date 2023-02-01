<?php

namespace App\Http\Controllers\Admin\Hr;

use App\User;
use App\SmStaff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SmParent;
use Illuminate\Support\Facades\Auth;

class StaffAsParentController extends Controller
{  
   public function loginAsRole()
   {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $staff = $user->staff; 
        $previous_role_id = $staff->previous_role_id;   //4   
        $staff->update([           
            'role_id'=>$previous_role_id, //4
        ]);
        $user->role_id= $previous_role_id; //4
        $user->save();       
        $this->loginLogout($user->id);
        return redirect()->route('admin-dashboard');
   }
   public function loginAsParent()
   {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $staff = $user->staff;       
        $staff->update([
            'previous_role_id'=>$user->role_id, //4
            'role_id'=>3,
        ]);
        $user->role_id= 3;
        $user->save();
        $this->loginLogout($user->id);
        return redirect()->route('parent-dashboard');
    
   }
   private function loginLogout($user_id)
   {
        Auth::logout();        
        \Artisan::call('optimize:clear');
        Auth::loginUsingId($user_id);
   }
    public function staff($email = null, $mobile = null)
    {
        if($email && $mobile) {
            return null;
        }
       $staff = SmStaff::when($mobile && !$email, function ($q) use ($mobile){
            $q->where('mobile', $mobile);
        })
        ->when($email && !$mobile, function ($q) use ($email){
            $q->where('email', $email);
        })
        ->when($email && $mobile, function ($q) use ($mobile){
            $q->where('mobile', $mobile);
        })        
        ->first(['id', 'parent_id', 'user_id']);
        if (!$staff) {
            if ($email && $mobile) {
                $staff = SmStaff::where('email', $email)->first(['id', 'parent_id', 'user_id']);
            }
        }
        return $staff;
    }
    public function parent($email = null, $mobile = null)
    {
        if($email && $mobile) {
            return null;
        }
        $parent = SmParent::when($mobile && !$email, function ($q) use ($mobile){
            $q->where('guardians_mobile', $mobile);
        })
        ->when($email && !$mobile, function ($q) use ($email){
            $q->where('guardians_email', $email);
        })
        ->when($email && $mobile, function ($q) use ($mobile){
            $q->where('guardians_mobile', $mobile);
        })
        ->first();

        return $parent;
    }
}
