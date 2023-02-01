<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZoomVirtualClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoom_virtual_class', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('meeting_id')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();

            $table->string('class_id')->nullable();
            $table->string('section_id')->nullable();

            //basic
            $table->string('topic')->nullable();
            $table->string('description')->nullable();
            $table->string('attached_file')->nullable();
            $table->string('date_of_meeting')->nullable();
            $table->string('time_of_meeting')->nullable();
            $table->string('meeting_duration')->nullable();
            $table->integer('time_before_start')->nullable();
            // setting
            $table->boolean('join_before_host')->nullable();
            $table->boolean('host_video')->nullable();
            $table->boolean('participant_video')->nullable();
            $table->boolean('mute_upon_entry')->nullable();
            $table->boolean('waiting_room')->nullable();
            $table->string('audio')->default('both')->comment('both, telephony & voip');
            $table->string('auto_recording')->default('none')->comment('local, cloud & none');
            $table->string('approval_type')->default(0)->comment('0 => Automatic, 1 => Manually & 2 No Registration');

            //recurring
            $table->boolean('is_recurring')->nullable();
                $table->tinyInteger('recurring_type')->nullable();
                $table->tinyInteger('recurring_repect_day')->nullable();
                $table->string('weekly_days')->nullable();
                $table->string('recurring_end_date')->nullable();

            $table->boolean('status')->default(1);
            $table->text('local_video')->nullable();
            $table->text('vedio_link')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
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
        Schema::dropIfExists('zoom_virtual_class');
    }
}
