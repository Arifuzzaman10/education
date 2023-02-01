<?php

use App\InfixModuleManager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfixBiometricsModuleToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         // InfixBiometrics
         $name = 'InfixBiometrics';
         $s = new InfixModuleManager();
         $s->name = $name;
         $s->email = 'support@spondonit.com';
         $s->notes = "This is InfixBiometrics module for live virtual class and meeting in this system at a time. Thanks for using.";
         $s->version = "1.0";
         $s->update_url = "";
         $s->is_default = 0;
         $s->addon_url = "";
         $s->installed_domain = url('/');
         $s->activated_date = date('Y-m-d');
         $s->save();

        $gname = 'GMeet';
        $gcheck = InfixModuleManager::where('name', $gname)->first();

        if (!$gcheck) {
            $s = new InfixModuleManager();
            $s->name = $gname;
            $s->email = '';
            $s->notes = "This is gmeet(google meet) module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "";
            $s->is_default = 0;
            $s->addon_url = "";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
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
