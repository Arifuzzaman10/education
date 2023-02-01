<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnForStaffsParent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
                      
            if(!Schema::hasColumn($table->getTable(), 'previous_role_id')) {
                $table->integer('previous_role_id')->after('role_id')->nullable();
            }   
            if(!Schema::hasColumn($table->getTable(), 'parent_id')) {
                $table->integer('parent_id')->after('previous_role_id')->nullable();
            }         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
