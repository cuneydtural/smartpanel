<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->increments('id');
            $table->string('site_name', 200)->nullable();
            $table->string('title', 200)->nullable();
            $table->string('url', 200)->nullable();
            $table->string('logo')->nullable();
            $table->text('keywords')->nullable();
            $table->text('desc')->nullable();
            $table->text('code_google')->nullable();
            $table->text('code_yandex')->nullable();
            $table->string('facebook_url', 100)->default('http://www.facebook.com/');
            $table->string('twitter_url', 100)->default('http://www.twitter.com/');
            $table->string('googleplus_url', 100)->nullable();
            $table->string('youtube_url', 100)->nullable();
            $table->string('linkedin_url', 100)->nullable();
            $table->string('instagram_url', 100)->nullable();
            $table->string('swarm_url', 100)->nullable();
            $table->string('pinterest_url', 100)->nullable();
            $table->string('foursquare_url', 100)->nullable();
            $table->string('mail_address', 100)->nullable();
            $table->string('mail_host', 100)->nullable();
            $table->string('mail_user', 100)->nullable();
            $table->string('mail_password', 100)->nullable();
            $table->integer('slide_w')->default(800);
            $table->integer('slide_h')->default(400);
            $table->integer('thumb_w')->default(170);
            $table->integer('thumb_h')->default(130);
            $table->integer('blog_w')->default(350);
            $table->integer('blog_h')->default(270);
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
        Schema::drop('settings');
    }
}
