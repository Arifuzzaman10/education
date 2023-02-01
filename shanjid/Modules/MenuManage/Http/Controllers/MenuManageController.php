<?php

namespace Modules\MenuManage\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Modules\MenuManage\Entities\SidebarNew;
use Modules\RolePermission\Entities\InfixRole;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;


class MenuManageController extends Controller
{

    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index()
    {
       
        $user = Auth::user();
        $assign_module_ids = InfixPermissionAssign::where('school_id', Auth::user()->school_id)
            ->where('role_id', $user->role_id)
            ->get('module_id');

        $permission_all_ids = InfixPermissionAssign::where('school_id', Auth::user()->school_id)
            ->where('role_id', $user->role_id)->get();

        $permission_ids = [];
        foreach ($permission_all_ids as $ids) {
            $permission_ids[] = $ids->module_id;
        }


        $check_sidebar = SidebarNew::roleUser()->first();
        $assign_modules = SidebarNew::roleUser()->where('active_status', 1)->get();

        $already_assigned = [];
        foreach ($assign_modules as $assign_module) {
            $already_assigned[] = $assign_module->infix_module_id;
        }
         $lms_id_remove = [1513, 1537, 1578, 1575,1580,1585,1600];

        if (!in_array($user->role_id, [2, 3])) {

            $infix = InfixModuleInfo::query();
            if (moduleStatusCheck('Zoom') == FALSE) {
                $infix->where('module_id', '!=', 22);
            }
            if (moduleStatusCheck('ParentRegistration') == FALSE) {
                $infix->where('module_id', '!=', 21);
            }

            if (moduleStatusCheck('InfixBiometrics') == FALSE) {
                $infix->where('module_id', '!=', 251);
            }

            if (moduleStatusCheck('Jitsi') == FALSE) {
                $infix->where('module_id', '!=', 30);
            }

            if (moduleStatusCheck('Lesson') == FALSE) {
                $infix->where('module_id', '!=', 29);
            }

            if (moduleStatusCheck('BBB') == FALSE) {
                $infix->where('module_id', '!=', 33);
            }
            if (moduleStatusCheck('Saas') == True) {
                $infix->whereNotIn('module_id', [19, 20]);
            }
            if ($user->role_id != 1) {
                $infix->whereIn('id', $assign_module_ids);
            }
            if (moduleStatusCheck('OnlineExam') == FALSE) {
                $infix->where('module_id', '!=', 101);
            }
            if (moduleStatusCheck('OnlineExam') == True) {
                $infix->where('module_id', '!=', 51);
                $infix->where('module_id', '!=', 43);
            }


            $infix = $infix->where('module_id', '!=', 1)->where('is_saas', 0)->where('parent_id', 0)->whereNotIn('id', $lms_id_remove)->where('active_status', 1)->groupBy('module_id')->get();
            $sidebar = SidebarNew::query();
            if (moduleStatusCheck('Zoom') == FALSE) {
                $sidebar->where('module_id', '!=', 22);
            }
            if (moduleStatusCheck('ParentRegistration') == FALSE) {
                $sidebar->where('module_id', '!=', 21);
            }
            if (moduleStatusCheck('Jitsi') == FALSE) {
                $sidebar->where('module_id', '!=', 30);
            }

            if (moduleStatusCheck('Lesson') == FALSE) {
                $sidebar->where('module_id', '!=', 29);
            }
            if (moduleStatusCheck('BBB') == FALSE) {
                $sidebar->where('module_id', '!=', 33);
            }
            if (moduleStatusCheck('Saas') == True) {
                $sidebar->whereNotIn('module_id', [19, 20]);
            }

            if (moduleStatusCheck('InfixBiometrics') == FALSE) {
                $sidebar->where('module_id', '!=', 251);
            }

           
            // if (moduleStatusCheck('OnlineExam')== FALSE) {
            //     $sidebar->where('module_id','!=',101);
            // }

            $sidebar = $sidebar->where('parent_id', 0)->groupBy('module_id')->roleUser()->orderby('id', 'ASC')->get();
            $all_modules = $check_sidebar ? $sidebar : $infix;


            if ($check_sidebar) {

                $all_install_module = [];

                foreach ($infix as $module_id) {
                    $all_install_module[] = $module_id->module_id;
                }

                $previous_module = [];

                foreach ($sidebar as $module_id) {
                    $previous_module[] = $module_id->module_id;
                }
                $newIntalls = array_diff($all_install_module, $previous_module);
                if (!is_null($newIntalls)) {
                    $newModules = InfixModuleInfo::whereIn('module_id', $newIntalls)->groupby('module_id')->where('active_status', 1)->get();

                } else {
                    $newModules = [];
                }
            } else {
                $newModules = [];
            }

            //   return $newModules;


            //    $all_modules = $infix ;
            return view('menumanage::index', compact('all_modules', 'already_assigned', 'check_sidebar', 'permission_ids', 'sidebar', 'newModules'));

        } elseif ($user->role_id == 2 || $user->role_id == 3) {
            // for student parent
            if ($user->role_id == 2) {
                $user_type = 1;
            } elseif ($user->role_id = 3) {
                $user_type = 2;
            }
            $infixStudentParent = InfixModuleStudentParentInfo::query();
            if (moduleStatusCheck('Jitsi') == FALSE) {
                $infixStudentParent->where('module_id', '!=', 2030);
            }

            if (moduleStatusCheck('InfixBiometrics') == FALSE) {
                $infixStudentParent->where('module_id', '!=', 251);
            }

            if (moduleStatusCheck('Zoom') == FALSE) {
                $infixStudentParent->where('module_id', '!=', 2022);
            }
            
            if (moduleStatusCheck('OnlineExam') == FALSE) {
                $infixStudentParent->where('module_id', '!=', 101);
            }

            if (moduleStatusCheck('BBB') == FALSE) {
                $infixStudentParent->where('module_id', '!=', 2033);
            }

            if (moduleStatusCheck('OnlineExam') == FALSE) {
                $infixStudentParent->where('module_id', '!=', 101);
            }
            if (moduleStatusCheck('OnlineExam') == True) {
                $infixStudentParent->where('module_id', '!=', 10);
            }
            if (moduleStatusCheck('OnlineExam') == True) {
                $infixStudentParent->where('module_id', '!=', 100);
            }

            $infixStudentParent->whereIn('id', $assign_module_ids);

            $infixStudentParent = $infixStudentParent->where('active_status', 1)->where('user_type', $user_type)->where('parent_id', 0)->get();

            $sidebar = SidebarNew::query();
           
            if (moduleStatusCheck('Jitsi') == FALSE) {
                $sidebar->where('module_id', '!=', 2030);
            }

            if (moduleStatusCheck('Zoom') == FALSE) {
                $sidebar->where('module_id', '!=', 2022);
            }

            if (moduleStatusCheck('InfixBiometrics') == FALSE) {
                $sidebar->where('module_id', '!=', 251);
            }

            if (moduleStatusCheck('BBB') == FALSE) {
                $sidebar->where('module_id', '!=', 2033);
            }
            $sidebar = $sidebar->where('parent_id', 0)->roleUser()->groupBy('module_id')->orderby('id', 'ASC')->get();

            $student_parent_menu = $check_sidebar ? $sidebar : $infixStudentParent;

            if ($check_sidebar) {

                $paid_module_ids = [];

                foreach ($infixStudentParent as $module_ids) {
                    $paid_module_ids[] = $module_ids->module_id;
                }

                $old_module = [];
                foreach ($sidebar as $module) {
                    $old_module[] = $module->module_id;
                }


                $newModuleIntalls = array_diff($paid_module_ids, $old_module);


                if (!is_null($newModuleIntalls)) {
                    $studentNewModules = InfixModuleStudentParentInfo::whereIn('module_id', $newModuleIntalls)->groupby('module_id')->where('active_status', 1)->get();
                } else {
                    $studentNewModules = [];
                }
            } else {
                $studentNewModules = [];
            }

            return view('menumanage::student_parent_sidebar', compact('check_sidebar', 'already_assigned', 'student_parent_menu', 'permission_ids', 'studentNewModules'));
            //end student parent
        }

    }


    public function store(Request $request)
    {


        try {
            $user = Auth::user();
            $checked_ids = $request->module_id;
            SidebarNew::where('user_id', $user->id)->where('role_id', $user->role_id)->delete();
            foreach ($request->all_modules_id as $key => $id) {

                $status = in_array($id, $checked_ids) ? 1 : 0;

                $sidebar = new SidebarNew;
                $sidebar->infix_module_id = $id;
                if ($user->role_id == 2 || $user->role_id == 3) {
                    $student_p = InfixModuleStudentParentInfo::find($id);
                    $sidebar->module_id = $student_p ? $student_p->module_id : ' ';
                    $sidebar->route = $student_p ? $student_p->route : ' ';
                    $sidebar->name = $student_p ? $student_p->name : ' ';
                    $sidebar->parent_id = $student_p ? $student_p->parent_id : ' ';
                    $sidebar->type = $student_p ? $student_p->type : ' ';
                } else {
                    $infix_module = InfixModuleInfo::find($id);
                    $sidebar->module_id = $infix_module ? $infix_module->module_id : ' ';
                    $sidebar->route = $infix_module ? $infix_module->route : ' ';
                    $sidebar->name = $infix_module ? $infix_module->name : ' ';
                    $sidebar->parent_id = $infix_module ? $infix_module->parent_id : ' ';
                    $sidebar->type = $infix_module ? $infix_module->type : ' ';
                }
                $sidebar->role_id = auth()->user()->role_id;
                $sidebar->user_id = auth()->user()->id;
                $sidebar->school_id = auth()->user()->school_id;
                $sidebar->active_status = $status;
                $sidebar->parent_position_no = $key;
                $sidebar->child_position_no = $key;
                $sidebar->save();


            }


            Toastr::success('Successfully Insert', 'Success');
            return redirect()->back();

        } catch (\Throwable $th) {
            Toastr::error('Operation Failed', 'Error');
            return redirect()->back();
        }
    }

    public function manage()
    {

        $id = Auth::user()->role_id;
        $role = InfixRole::where('is_saas', 0)->where('id', $id)->first();
        $all_modules = InfixModuleInfo::where('is_saas', 0)->where('active_status', 1)->get();
        $all_modules = $all_modules->groupBy('module_id');
        $all_sidebars = SidebarNew::where('is_saas', 0)->groupBy('module_id')->get();
        return view('menumanage::all_sidebar_menu', compact('role', 'all_modules', 'all_sidebars'));
    }

    public function reset()
    {
        try {

            $user = Auth::user();
            SidebarNew::where('user_id', $user->id)->where('role_id', $user->role_id)->delete();
            Toastr::success('Operation Successful', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


}