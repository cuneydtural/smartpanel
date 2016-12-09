<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticlesTablosunuOlustur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('category')->nullable()->index();
            $table->string('title', 200)->nullable();
            $table->text('desc')->nullable();
            $table->string('keywords')->nullable();
            $table->longText('content')->nullable();
            $table->integer('list_id')->unsigned()->default('0');
            $table->integer('active')->unsigned()->default('1');
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
        Schema::drop('articles');
    }
}
