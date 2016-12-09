<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryLangsTablosuEklendi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_langs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('category_id')->nullable()->index();
            $table->string('name', 255);
            $table->string('slug', 255)->index();
            $table->string('locale')->nullable()->index();
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
        Schema::drop('category_langs');
    }
}
