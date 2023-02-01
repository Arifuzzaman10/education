<?php
use App\InfixModuleManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduUpdateKhaltiTable extends Migration
{
    public function up()
    {

        $name ="KhaltiPayment";
        if (!Schema::hasColumn('sm_general_settings', $name)) {
            Schema::table('sm_general_settings', function ($table) use ($name) {
                $table->integer('KhaltiPayment')->default(0)->nullable();
            });
        } 

        $name ="AppSlider";
        if (!Schema::hasColumn('sm_general_settings', $name)) {
            Schema::table('sm_general_settings', function ($table) use ($name) {
                $table->integer('AppSlider')->default(0)->nullable();
            });
        } 

        $module = "KhaltiPayment";
        $exist = InfixModuleManager::where('name',$module)->first();

        if(! $exist){
            $s = new InfixModuleManager();
            $s->name = "KhaltiPayment";
            $s->email = 'support@spondonit.com';
            $s->notes = "Khalti Is A Online Payment Gatway Module For Collect Fees Online";
            $s->version = 1.0;
            $s->update_url = "support@spondonit.com";
            $s->is_default = 0;
            $s->purchase_code = null;
            $s->installed_domain = null;
            $s->activated_date = null;
            $s->save();
        }  
        
        

        $module = "AppSlider";
        $exist = InfixModuleManager::where('name',$module)->first();

        if(! $exist){
            $s = new InfixModuleManager();
            $s->name = "AppSlider";
            $s->email = 'support@spondonit.com';
            $s->notes = "AppSlider is for add slider which used in infixedu mobile app, for affiliation";
            $s->version = 1.0;
            $s->update_url = "support@spondonit.com";
            $s->is_default = 0;
            $s->purchase_code = null;
            $s->installed_domain = null;
            $s->activated_date = null;
            $s->save();
        } 
    }
    
    public function down()
    {
        Schema::dropIfExists('update_version');
    }
}
