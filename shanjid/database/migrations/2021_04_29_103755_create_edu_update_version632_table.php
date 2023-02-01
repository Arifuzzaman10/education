<?php

use App\InfixModuleManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduUpdateVersion632Table extends Migration
{

    public function up()
    {
        $name = "Raudhahpay";
        if (!Schema::hasColumn('sm_general_settings', $name)) {
            Schema::table('sm_general_settings', function ($table) use ($name) {
                $table->integer('Raudhahpay')->default(1);

            });

            $name2 = 'Raudhahpay';
            $saas = InfixModuleManager::where('name', $name2)->first();
            if (!($saas)) {
                $s = new InfixModuleManager();
                $s->name = $name2;
                $s->email = 'support@spondonit.com';
                $s->notes = "This is Saas module for Online Payment. Thanks for using.";
                $s->version = "1.0";
                $s->update_url = "https://spondonit.com/contact";
                $s->is_default = 0;
                $s->addon_url = "mailto:support@spondonit.com";
                $s->installed_domain = url('/');
                $s->activated_date = date('Y-m-d');
                $s->save();

            }


        }
    }

}
