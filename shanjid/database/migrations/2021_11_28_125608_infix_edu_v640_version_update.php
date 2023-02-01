<?php

use App\InfixModuleManager;
use App\SmContactPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;

class InfixEduV640VersionUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // AppSlider
        $check = InfixModuleManager::where('name', 'AppSlider')->firstOrFail();
        if(!$check){
            $XenditPayment = 'AppSlider';
            $XenditPayment = new InfixModuleManager();
            $XenditPayment->name = 'AppSlider';
            $XenditPayment->email = 'support@spondonit.com';
            $XenditPayment->notes = "This is for school affiliate banner for mobile app. Thanks for using.";
            $XenditPayment->version = "1.0";
            $XenditPayment->update_url = "https://spondonit.com/contact";
            $XenditPayment->is_default = 0;
            $XenditPayment->addon_url = "mailto:support@spondonit.com";
            $XenditPayment->installed_domain = url('/');
            $XenditPayment->activated_date = date('Y-m-d');
            $XenditPayment->save();
        }

        // Wallet
        $dataPath = 'Modules/Wallet/Wallet.json';
        $name = 'Wallet';
        $strJsonFileContents = file_get_contents($dataPath);
        $array = json_decode($strJsonFileContents, true);

        $version = $array[$name]['versions'][0];
        $url = $array[$name]['url'][0];
        $notes = $array[$name]['notes'][0];

        $check = InfixModuleManager::where('name', $name)->first();
        if (!$check) {
            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
        }

        // Fees
        $dataPath = 'Modules/Fees/Fees.json';
        $name = 'Fees';
        $strJsonFileContents = file_get_contents($dataPath);
        $array = json_decode($strJsonFileContents, true);

        $version = $array[$name]['versions'][0];
        $url = $array[$name]['url'][0];
        $notes = $array[$name]['notes'][0];
        $check = InfixModuleManager::where('name', $name)->first();
        if (!$check) {
            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
        }


        $controller = new \App\Http\Controllers\Admin\SystemSettings\SmAddOnsController();
        $controller->FreemoduleAddOnsEnable('Fees');
        $controller = new \App\Http\Controllers\Admin\SystemSettings\SmAddOnsController();
        $controller->FreemoduleAddOnsEnable('Wallet');


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
