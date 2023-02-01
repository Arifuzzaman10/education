<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordOptionalSubjectTable extends Migration
{
    public function up()
    {
        $column = "record_id";
        if (!Schema::hasColumn('sm_optional_subject_assigns', $column)) {
            Schema::table('sm_optional_subject_assigns', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('record_optional_subject');
    }
}
