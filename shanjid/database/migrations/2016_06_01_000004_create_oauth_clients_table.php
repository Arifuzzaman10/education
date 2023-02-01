<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_clients', function (Blueprint $table) {

            $table->increments('id');
            $table->bigInteger('user_id')->index()->nullable();

            $table->string('provider')->nullable();
            $table->string('name');
            $table->string('secret', 200);
            $table->text('redirect');
            $table->boolean('personal_access_client');
            $table->boolean('password_client');
            $table->boolean('revoked');
            $table->timestamps();

            // $table->increments('id');
            // $table->bigInteger('access_token_id')->index()->nullable();

            // $table->string('name');
            // $table->string('secret', 200);
            // $table->text('redirect');
            // $table->boolean('personal_access_client');
            // $table->boolean('password_client');
            // $table->boolean('revoked');
            // $table->timestamps();

        
        });
            try {
                $redirect_url=app_url();
            } catch (\Throwable $th) {
                $redirect_url=url('/');
            }
        DB::table('oauth_clients')->insert(
            array(
                   'provider'     =>   null, 
                   'name'   =>   'Laravel Personal Access Client',
                   'secret'   =>   '2e1LEl0zBTmD8XN4sa0meCTtKslUBpShKW4AGrej',
                   'redirect'   =>   $redirect_url,
                   'personal_access_client'   =>   1,
                   'password_client'   =>   0,
                   'revoked'   =>   0
            )
       );

        DB::table('oauth_clients')->insert(
            array(
                   'provider'     =>   'users', 
                   'name'   =>   'Laravel Password Grant Client',
                   'secret'   =>   'oDaHAi0ml3To8OC7Da10TGVUm7zjhMyq00cmwoDZ',
                   'redirect'   =>   $redirect_url,
                   'personal_access_client'   =>   0,
                   'password_client'   =>   1,
                   'revoked'   =>   0
            )
       );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_clients');
    }
}
