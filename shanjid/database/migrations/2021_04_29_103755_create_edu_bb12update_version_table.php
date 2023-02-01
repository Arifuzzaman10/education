<?php
use App\SmPage;
use App\InfixModuleManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEduBB12UpdateVersionTable extends Migration
{
    public function up()
    {
        try{
            $name2 = 'BBB';
            $bbb = InfixModuleManager::where('name',$name2)->first();
            if($bbb){
                $bbb->version = "1.2";
                $bbb->save();
            }
             

        }catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
    
    public function down()
    {
        Schema::dropIfExists('update_version');
    }
}
