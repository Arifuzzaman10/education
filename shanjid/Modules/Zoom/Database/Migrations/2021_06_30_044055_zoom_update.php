<?php

use App\SmWeekend;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ZoomUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{

            $name2 ="zoom_api_key_of_user";
            if (!Schema::hasColumn('users', $name2)) {
                Schema::table('users', function ($table) use ($name2) {
                    $table->text('zoom_api_key_of_user')->nullable();
                });
            }
         $name3 ="zoom_api_serect_of_user";
            if (!Schema::hasColumn('users', $name3)) {
                Schema::table('users', function ($table) use ($name3) {
                    $table->text('zoom_api_serect_of_user')->nullable();
                });
            }
            $name4 ="zoom_order";
            if (!Schema::hasColumn('sm_weekends', $name4)) {
                Schema::table('sm_weekends', function ($table) use ($name4) {
                    $table->integer('zoom_order')->nullable();
                });
            }


            $saturday=SmWeekend::where('name','Saturday')->first();
            if($saturday){
                $saturday->zoom_order=7;
                $saturday->save();
            }

            $sunday=SmWeekend::where('name','Sunday')->first();
            if($sunday){
                $sunday->zoom_order=1;
                $sunday->save();
            }

            $monday=SmWeekend::where('name','Monday')->first();
            if($monday){
                $monday->zoom_order=2;
                $monday->save();
            }

            $tuesday=SmWeekend::where('name','Tuesday')->first();
            if($tuesday){
                $tuesday->zoom_order=3;
                $tuesday->save();
            }

            $wednesday=SmWeekend::where('name','Wednesday')->first();
            if($wednesday){
                $wednesday->zoom_order=4;
                $wednesday->save();
            }

            $thursday=SmWeekend::where('name','Thursday')->first();
            if($thursday){
                $thursday->zoom_order=5;
                $thursday->save();
            }

            
            $friday=SmWeekend::where('name','Friday')->first();
            if($friday){
                $friday->zoom_order=6;
                $friday->save();
            }
        }catch (\Exception $e) {
            Log::info($e->getMessage());
        }
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
