<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\ParentRegistration\Entities\SmRegistrationSetting;



class CreateSmRegistrationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_registration_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('position')->default(1)->comment('1=Header, 2=Footer, 0=hide');
            $table->integer('registration_permission')->default(1)->comment('1=enable, 2=Disable');
            $table->integer('registration_after_mail')->default(1)->comment('1=enable, 2=Disable');
            $table->integer('approve_after_mail')->default(1)->comment('1=enable, 2=Disable');

            $table->integer('recaptcha')->default(1)->comment('1=enable, 2=Disable');
            $table->string('nocaptcha_sitekey')->nullable();
            $table->string('nocaptcha_secret')->nullable();

            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();
            $table->integer('school_id')->nullable()->default(1)->unsigned();

             $table->integer('academic_id')->nullable()->default(1)->unsigned();
            $table->foreign('academic_id')->references('id')->on('sm_academic_years')->onDelete('cascade');

            $table->timestamps();
        });

        $setting = new SmRegistrationSetting();

        $setting->recaptcha = 2;

        $setting->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_student_registrations');
    }
}
