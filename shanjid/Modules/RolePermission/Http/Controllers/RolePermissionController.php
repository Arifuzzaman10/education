<?php

namespace Modules\RolePermission\Http\Controllers;

use App\User;
use Validator;
use App\tableList;
use App\ApiBaseMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\InfixRole;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Http\Requests\RoleRequest;
use Modules\RolePermission\Entities\InfixPermissionAssign;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
       
        return view('rolepermission::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('rolepermission::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        
        return view('rolepermission::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('rolepermission::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function role(Request $request)
    {
        try {

            $roles = InfixRole::where('is_saas',0)->when((generalSetting()->with_guardian !=1), function ($query) {
                $query->where('id', '!=', 3);
            })->where('active_status', '=', 1)
                ->where(function ($q) {
                    $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
                })
                ->where('id', '!=', 1)
                ->orderBy('id', 'desc')
                ->get();
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse($roles, null);
            }
            return view('rolepermission::role', compact('roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }



    public function roleStore(RoleRequest $request)
    {

        try {
            
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $role = new InfixRole();
            $role->name = $request->name;
            $role->type = 'User Defined';
            $role->school_id = Auth::user()->school_id;
            $role->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function roleEdit(Request $request, $id)
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $role = InfixRole::find($id);
            $roles = InfixRole::where('is_saas',0)->where('active_status', '=', 1)
                ->where(function ($q) {
                    $q->where('school_id', Auth::user()->school_id)->orWhere('type', 'System');
                })
                ->where('id', '!=', 1)
                ->orderBy('id', 'desc')
                ->get();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                $data = [];
                $data['role'] = $role;
                $data['roles'] = $roles->toArray();
                return ApiBaseMethod::sendResponse($data, null);
            }
            return view('rolepermission::role', compact('role', 'roles'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function roleUpdate(RoleRequest $request)
    {

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $role = InfixRole::find($request->id);
            $role->name = $request->name;
            $result = $role->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
           
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
    public function roleDelete(Request $request)
    {
        try {
            $tables = \App\tableList::getTableList('role_id', $request->id);
            if ($tables == null) {
                $delete_query = InfixRole::destroy($request->id);
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();
            } else {
                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function assignPermission($id)
    {
        
        try {
           
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $role = InfixRole::where('is_saas',0)->where('id',$id)->first();
            $assign_modules = InfixPermissionAssign::where('school_id',Auth::user()->school_id)->where('role_id', $id)->get();
           

            $already_assigned = [];
            foreach ($assign_modules as $assign_module) {
                $already_assigned[] = $assign_module->module_id;
            }
            

            if ($id != 2 && $id != 3) {

                $all_modules = InfixModuleInfo::query();

                if (moduleStatusCheck('Zoom')== FALSE) {
                    $all_modules->where('module_id','!=',22);
                } 
                if (moduleStatusCheck('ParentRegistration')== FALSE) {
                    $all_modules->where('module_id','!=',21);
                } 

                if (moduleStatusCheck('InfixBiometrics') == FALSE) {
                    $all_modules->where('module_id', '!=', 251);
                }
            
                if (moduleStatusCheck('Jitsi')== FALSE) {
                    $all_modules->where('module_id','!=',30);
                }

                if (moduleStatusCheck('Lesson')== FALSE) {
                    $all_modules->where('module_id','!=',29);
                }
                 if (moduleStatusCheck('BBB')== FALSE) {
                    $all_modules->where('module_id','!=',33);
                }
                 if (moduleStatusCheck('OnlineExam')== FALSE) {
                    $all_modules->where('module_id','!=',32);
                }

                if (moduleStatusCheck('Saas')== True) {
                    $all_modules->whereNotIn('module_id',[19,20]);
                }


                if (moduleStatusCheck('OnlineExam')== FALSE) {
                    $all_modules->where('module_id','!=',101);
                } 


                if (moduleStatusCheck('OnlineExam')== FALSE) {
                    $all_modules->where('module_id','!=',101);
                } 
                if (moduleStatusCheck('OnlineExam')== True) {
                    $all_modules->where('module_id','!=',51);
                }

                if (moduleStatusCheck('Lms')== True) {
                    if($id != 4){
                        $all_modules->where('id','!=',1564);
                        $all_modules->where('id','!=',1565);
                    }
                }

                if (!moduleStatusCheck('University')) {
                    $all_modules->whereNotIn('id',[5000,5001]);
                }

                $all_modules =  $all_modules->where('is_saas',0)->where('parent_id',0)->where('active_status', 1)->get();
                // $all_modules = InfixModuleInfo::where('is_saas',0)->where('active_status', 1)->where('module_id','!=',22)->get();


                $all_modules = $all_modules->groupBy('module_id');


                return view('rolepermission::role_permission', compact('role', 'all_modules', 'already_assigned'));
            } else {

                if ($id == 2) {
                    $user_type = 1;
                } else {
                    $user_type = 2;
                }

                $all_modules=InfixModuleStudentParentInfo::query();

                if (moduleStatusCheck('Zoom')== FALSE) {
                    $all_modules->where('module_id','!=',2022);
                } 
          
            
                if (moduleStatusCheck('Jitsi')== FALSE) {
                    $all_modules->where('module_id','!=',2030);
                }

                 if (moduleStatusCheck('BBB')== FALSE) {
                    $all_modules->where('module_id','!=',2033);
                }
                 if (moduleStatusCheck('OnlineExam')== FALSE) {
                    $all_modules->where('module_id','!=',101);
                }
                if (moduleStatusCheck('OnlineExam')== True) {
                    $all_modules->where('module_id','!=',10);
                }
                 if (moduleStatusCheck('OnlineExam')== true) {
                    $all_modules->where('module_id','!=',100);
                }

                $all_modules =$all_modules->where('active_status', 1)->where('user_type', $user_type)->where('parent_id', 0)->get();

                return view('rolepermission::role_permission_student', compact('role', 'all_modules', 'already_assigned', 'user_type'));
            }
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Failed');
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function rolePermissionAssign(Request $request)
    {
        
        
        DB::beginTransaction();

        try {
            Schema::disableForeignKeyConstraints();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            InfixPermissionAssign::where('school_id', Auth::user()->school_id)->where('role_id', $request->role_id)->delete();
            
            if ($request->module_id) {
                    
                foreach ($request->module_id as $module) {
                    
                    $assign = new InfixPermissionAssign();
                    $assign->module_id = $module;
                    $assign->role_id = $request->role_id;
                    $assign->school_id = Auth::user()->school_id;
                    $assign->save();
                }
            }

            DB::commit();
            // Toastr::success('User must be relogin again for applied permission changes', 'Success');
            Toastr::success('User permission applied successfully', 'Success');
            return redirect('rolepermission/role');
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error($e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }
}