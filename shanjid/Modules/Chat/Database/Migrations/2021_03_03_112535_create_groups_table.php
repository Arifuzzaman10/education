<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('photo_url')->nullable();
            $table->integer('privacy')->nullable();
            $table->boolean('read_only')->default(0);
            $table->integer('group_type')->default(1)->comment('1 => Open (Anyone can send message), 2 => Close (Only Admin can send message) ');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

//            $table->foreign('created_by')
//                ->references('id')->on('users')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_groups');
    }
}
