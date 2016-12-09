<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SlidesTablosunuOlustur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('photo', 255)->index();
            $table->string('title', 255)->index();
            $table->string('desc', 255);
            $table->string('url', 255);
            $table->integer("list_id")->nullable();
            $table->integer("active")->nullable();
            $table->string('locale')->default('tr')->index();
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
        Schema::drop('slides');
    }
}
