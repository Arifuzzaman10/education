<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecordIdToSmFeesAssignDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        $column ="record_id";
        if (!Schema::hasColumn('sm_fees_assign_discounts', $column)) {
            Schema::table('sm_fees_assign_discounts', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable()->constrained('student_records')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('sm_fees_assigns', $column)) {
            Schema::table('sm_fees_assigns', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable()->constrained('student_records')->cascadeOnDelete();
            });
        }


        if (!Schema::hasColumn('sm_fees_payments', $column)) {
            Schema::table('sm_fees_payments', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable()->constrained('student_records')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('sm_fees_discounts', $column)) {
            Schema::table('sm_fees_discounts', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable()->constrained('student_records')->cascadeOnDelete();
            });
        }


        if (!Schema::hasColumn('sm_homeworks', $column)) {
            Schema::table('sm_homeworks', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable()->constrained('student_records')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('sm_student_attendances', $column)) {
            Schema::table('sm_student_attendances', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable()->constrained('student_records')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('sm_student_take_online_exams', $column)) {
            Schema::table('sm_student_take_online_exams', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable()->constrained('student_records')->cascadeOnDelete();
            });
        }

        if (!Schema::hasColumn('sm_bank_payment_slips', $column)) {
            Schema::table('sm_bank_payment_slips', function (Blueprint $table) use ($column) {
                $table->foreignId($column)->unsigned()->nullable()->constrained('student_records');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $column ="record_id";
        if (Schema::hasColumn('sm_fees_assigns', $column)) {
            Schema::table('sm_fees_assigns', function (Blueprint $table) use ($column) {
                $table->dropForeign([$column]);
                $table->dropColumn($column);
            });
        }

        if (Schema::hasColumn('sm_fees_payments', $column)) {
            Schema::table('sm_fees_payments', function (Blueprint $table) use ($column) {
                $table->dropForeign([$column]);
                $table->dropColumn($column);
            });
        }

        if (Schema::hasColumn('sm_fees_discounts', $column)) {
            Schema::table('sm_fees_discounts', function (Blueprint $table) use ($column) {
                $table->dropForeign([$column]);
                $table->dropColumn($column);
            });
        }

        if (Schema::hasColumn('sm_fees_assign_discounts', $column)) {
            Schema::table('sm_fees_assign_discounts', function (Blueprint $table) use ($column) {
                $table->dropForeign([$column]);
                $table->dropColumn($column);
            });
        }

        if (Schema::hasColumn('sm_bank_payment_slips', $column)) {
            Schema::table('sm_bank_payment_slips', function (Blueprint $table) use ($column) {
                $table->dropForeign([$column]);
                $table->dropColumn($column);
            });
        }

        if (Schema::hasColumn('sm_homeworks', $column)) {
            Schema::table('sm_homeworks', function (Blueprint $table) use ($column) {
                $table->dropForeign([$column]);
                $table->dropColumn($column);
            });
        }

        if (Schema::hasColumn('sm_student_attendances', $column)) {
            Schema::table('sm_student_attendances', function (Blueprint $table) use ($column) {
                $table->dropForeign([$column]);
                $table->dropColumn($column);
            });
        }

        if (Schema::hasColumn('sm_student_take_online_exams', $column)) {
            Schema::table('sm_student_take_online_exams', function (Blueprint $table) use ($column) {
                $table->dropForeign([$column]);
                $table->dropColumn($column);
            });
        }
    }
}
