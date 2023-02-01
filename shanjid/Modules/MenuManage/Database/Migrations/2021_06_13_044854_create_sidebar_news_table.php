<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidebarNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebar_news', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->nullable(); 
            $table->string('name')->nullable();
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('parent_position_no')->nullable()->default(0);               
            $table->tinyInteger('active_status')->default(1);                        
         
            $table->integer('child_id')->nullable()->default(0);
            $table->integer('child_position_no')->nullable()->default(0);         
            $table->tinyInteger('child_active_status')->default(1);
            $table->string('route')->nullable();
            $table->integer('type')->nullable();
            $table->integer('infix_module_id')->nullable();
            // $table->foreign('infix_module_id')->references('id')->on('infix_module_infos')->onDelete('cascade');

            $table->integer('role_id')->nullable()->unsigned();
            // $table->foreign('role_id')->references('id')->on('infix_roles')->onDelete('cascade');

            $table->integer('user_id')->nullable()->unsigned();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            // $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sidebar_news');
    }
}
