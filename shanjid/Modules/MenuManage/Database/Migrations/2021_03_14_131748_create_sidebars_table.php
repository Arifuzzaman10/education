<?php


use Illuminate\Support\Facades\Schema;
use Modules\MenuManage\Entities\Sidebar;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;

class CreateSidebarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebars', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->nullable();
            
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('child_id')->nullable()->default(0);

          
            $table->string('lan_name',50)->nullable();
            $table->string('name')->nullable();
            $table->string('icon_class')->nullable();

            $table->tinyInteger('is_saas')->default(0);
            $table->string('route')->nullable();
            $table->tinyInteger('active_status')->default(1);
            
            $table->integer('infix_module_id')->nullable()->unsigned();
           

            $table->integer('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('infix_roles')->onDelete('cascade');

            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            $table->timestamps();
       
        });

        
        if (moduleStatusCheck('SaasRolePermission') == true) {
            $all_modules = InfixModuleInfo::query();

            if (moduleStatusCheck('Zoom')== FALSE) {
                $all_modules->where('module_id','!=',22);
            } 
            if (moduleStatusCheck('ParentRegistration')== FALSE) {
                $all_modules->where('module_id','!=',21);
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
    


            $all_modules =  $all_modules->where('module_id','!=',1)->where('active_status', 1)
                            ->whereNotIn('name',['add','edit','delete','download','print','view','Import Student'])
                            // ->where('route','!=','')
                            ->get();    

         }else{

            $all_modules = InfixModuleInfo::query();

            if (moduleStatusCheck('Zoom')== FALSE) {
                $all_modules->where('module_id','!=',22);
            } 
            if (moduleStatusCheck('ParentRegistration')== FALSE) {
                $all_modules->where('module_id','!=',21);
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
 

             $all_modules = $all_modules->where('module_id','!=',1)->whereNotIn('name',['add','edit','delete','download','print','view','Import Student'])
                            ->where('is_saas',0)
                            ->get();  
        }     

        if ($all_modules) {
                    
            foreach ($all_modules as $key=>$module) {

                $name=strtolower(str_replace(' ','_',$module->name));
                $name=str_replace(['_Menu','_module','_Module','_menu'],'',$name);

                $sidebar = new Sidebar();           
                $sidebar->name=str_replace(['Menu','menu','module','Module'],'',$module->name);
                $sidebar->icon_class=$module->icon_class;
                $sidebar->lan_name=$module->lang_name;
                $sidebar->module_id =$module->module_id;
                $sidebar->parent_id =$module->parent_id;
                $sidebar->infix_module_id=$module->id;
                $sidebar->route=$module->route;        
                $sidebar->save();
                }
          
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sidebars');
    }
}
