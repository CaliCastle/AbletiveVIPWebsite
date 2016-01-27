<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('maker', 50)->nullable();
            $table->string('baidu_link')->nullable();
            $table->string('qiniu_link')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('video_link');
            $table->string('tutorial_link')->nullable();
            $table->string('video_download')->nullable();
            $table->string('details_link')->nullable();
            $table->enum('difficulty', ['1星', '2星', '3星', '4星', '5星', '6星']);
            $table->boolean('has_tutorial')->default(false);
            $table->boolean('is_universal')->default(false);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
    }
}
