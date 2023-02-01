<?php

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('image');
            $table->integer('category_id');
            $table->text('overview')->nullable();
            $table->text('outline')->nullable();
            $table->text('prerequisites')->nullable();
            $table->text('resources')->nullable();
            $table->text('stats')->nullable();
            $table->integer('active_status')->default(1);
            $table->timestamps();

            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
        });


        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            DB::table('sm_courses')->insert([
                'title' => $faker->text(50),
                'image' => 'public/uploads/course/academic' . $i++ . '.jpg',
                'overview' => $faker->text(2000),
                'outline' => $faker->text(2000),
                'prerequisites' => $faker->text(2000),
                'resources' => $faker->text(2000),
                'stats' => $faker->text(2000),
                'active_status' => 1,
                'created_at' => date('Y-m-d h:i:s')
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_courses');
    }
}
