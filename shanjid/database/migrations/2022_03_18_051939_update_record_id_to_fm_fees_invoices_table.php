<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRecordIdToFmFeesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $feesInvoices = \Modules\Fees\Entities\FmFeesInvoice::whereNull('record_id')->get();

        foreach($feesInvoices as $invoice){
            $record = \App\Models\StudentRecord::where('school_id', $invoice->school_id)->where('academic_id', $invoice->academic_id)->where('class_id', $invoice->class_id)->where('student_id', $invoice->student_id)->first();
            if($record){
                $invoice->record_id = $record->id;
                $invoice->save();
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

    }
}
