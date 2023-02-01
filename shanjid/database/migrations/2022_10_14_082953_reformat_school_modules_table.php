<?php

use App\Models\SchoolModule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReformatSchoolModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $school_modules = SchoolModule::where('active_status', 1)->get()->groupBy('school_id');

        Schema::drop('school_modules');

        Schema::create('school_modules', function (Blueprint $table) {
            $table->id();
            $table->longText('modules')->nullable();
            $table->longText('menus')->nullable();

            $table->integer('school_id')->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            $table->timestamps();
        });

        foreach($school_modules as $school_id => $school_module){
            if($school_id == 1){
                continue;
            }
            $module = $school_module->pluck('module_name')->unique()->map(function ($v){
                return ucfirst($v);
            })->toArray();


            $menus = collect(planPermissions('menus'))->keys()->toArray();

            $s = new SchoolModule();
            $s->modules = $module;
            $s->menus = $menus;
            $s->school_id = $school_id;
            $s->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $school_modules = SchoolModule::get();
        Schema::dropIfExists('school_modules');
        Schema::create('school_modules', function (Blueprint $table) {
            $table->id();
            $table->string('module_name')->nullable();
            $table->integer('updated_by')->nullable();
            $table->tinyInteger('active_status')->default(1);
            $table->integer('school_id')->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');

            $table->integer('academic_id')->nullable()->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');
            $table->timestamps();
        });

        foreach($school_modules as $school_module){
            foreach($school_module->modules as $module){
                $exists = SchoolModule::where('school_id', $school_module->school_id)->where('module_name', $module)->first();
                if (!$exists){
                    $settings = new SchoolModule;
                    $settings->module_name = strtolower($module);
                    $settings->school_id = $school_module->school_id;
                    $settings->active_status = 1;
                    $settings->updated_by = 1;
                    $settings->save();
                }
            }
        }
    }
}
