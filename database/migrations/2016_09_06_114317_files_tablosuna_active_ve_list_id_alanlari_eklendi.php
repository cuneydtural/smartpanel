<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilesTablosunaActiveVeListIdAlanlariEklendi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function($table){
            $table->integer('list_id')->nullable()->default(0);
            $table->integer('active')->default(1)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function($table){
            $table->dropColumn('list_id');
            $table->dropColumn('active');
        });
    }
}
