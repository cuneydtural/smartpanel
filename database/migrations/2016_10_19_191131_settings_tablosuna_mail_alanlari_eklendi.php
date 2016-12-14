<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsTablosunaMailAlanlariEklendi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function($table){
            $table->string('mail_driver')->nullable()->default('smtp');
            $table->string('mail_to')->nullable();
            $table->string('mail_port')->nullable()->default(587);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function($table) {
            $table->dropColumn('mail_driver');
            $table->dropColumn('mail_to');
            $table->dropColumn('mail_port');
        });
    }
}
