<?php

use App\InfixModuleManager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertExamplanToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $dataPath = 'Modules/ExamPlan/ExamPlan.json';
        $name = 'ExamPlan';
        $strJsonFileContents = file_get_contents($dataPath);
        $array = json_decode($strJsonFileContents, true);

        $version = $array[$name]['versions'][0];
        $url = $array[$name]['url'][0];
        $notes = $array[$name]['notes'][0];

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

        $controller = new \App\Http\Controllers\Admin\SystemSettings\SmAddOnsController();
        $controller->FreemoduleAddOnsEnable('ExamPlan');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            //
        });
    }
}
