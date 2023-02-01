<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesForUniversityTable extends Migration
{
    public function up()
    {
        Schema::table('sm_fees_groups', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_fees_groups', 'un_semester_label_id',)) {
                $table->integer('un_semester_label_id')->nullable();
            }
        });

        Schema::table('sm_fees_types', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_fees_types', 'un_semester_label_id',)) {
                $table->integer('un_semester_label_id')->nullable();
            }
        });

        Schema::table('sm_fees_masters', function (Blueprint $table) {
            if (!Schema::hasColumn('sm_fees_masters', 'un_semester_label_id',)) {
                $table->integer('un_semester_label_id')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('fees_for_university');
    }
}
