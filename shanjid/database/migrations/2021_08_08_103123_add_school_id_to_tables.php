<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolIdToTables extends Migration
{
    protected $tables = [
        "sm_pages",
        "sm_custom_links",
        "sm_frontend_persmissions",
        "sm_header_menu_managers",
        "sm_home_page_settings",
        "sm_language_phrases",
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        foreach($this->tables as $table){
            if (!Schema::hasColumn($table, 'school_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->integer('school_id')->nullable()->default(1)->unsigned();
                    $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
                });
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
        foreach($this->tables as $table){
            if (Schema::hasColumn($table, 'school_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['school_id']);
                    $table->dropColumn('school_id');
                });
            }
        }
        
    }
}
