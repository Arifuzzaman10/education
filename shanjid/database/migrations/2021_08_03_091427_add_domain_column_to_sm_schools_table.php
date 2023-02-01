<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDomainColumnToSmSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_schools', function (Blueprint $table) {
            $table->string('domain', 191)->nullable()->after('email');
        });

        // 'domain' => 'school',

        DB::table('sm_schools')->where('id', 1)->update(['domain' => 'school']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_schools', function (Blueprint $table) {
            $table->dropColumn('domain');
        });
    }
}
