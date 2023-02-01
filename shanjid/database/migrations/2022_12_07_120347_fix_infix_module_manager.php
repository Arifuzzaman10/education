<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixInfixModuleManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $gmeet = \App\InfixModuleManager::where('name', 'GMeet')->first();

        if($gmeet){
            $gmeet->name = 'Gmeet';
            $gmeet->save();
        }
        $bios = \App\InfixModuleManager::where('name', 'InfixBiometrics')->get();

        if($bios->count() > 1){
            App\InfixModuleManager::where('name', 'InfixBiometrics')->where('id', '!=', $bios->first()->id)->delete();
        }

        Schema::table('sm_fees_payments', function (Blueprint $table) {
            if(!Schema::hasColumn($table->getTable(), 'direct_fees_installment_assign_id')){
                $table->integer('direct_fees_installment_assign_id')->nullable()->unsigned();
            }
            if(!Schema::hasColumn($table->getTable(), 'installment_payment_id')){
                $table->integer('installment_payment_id')->nullable()->unsigned();
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
