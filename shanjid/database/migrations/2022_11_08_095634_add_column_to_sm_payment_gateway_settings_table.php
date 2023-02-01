<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToSmPaymentGatewaySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_payment_gateway_settings', function (Blueprint $table) {
            if(!Schema::hasColumn('sm_payment_gateway_settings', 'service_charge')) {
                $table->boolean('service_charge')->nullable()->default(false);
            }
            if(!Schema::hasColumn('sm_payment_gateway_settings', 'charge_type')) {
                $table->string('charge_type',2)->nullable()->comment('P=percentage, F=Flat');
            }
            if(!Schema::hasColumn('sm_payment_gateway_settings', 'charge')) {
                $table->float('charge')->nullable()->default(0.00);
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
        Schema::table('sm_payment_gateway_settings', function (Blueprint $table) {
            $dropColumns = ['service_charge', 'charge_type', 'charge'];
            $table->dropColumn($dropColumns);
        });
    }
}
