<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FilesRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("file_id")->nullable();
            $table->string("file_type")->nullable();
            $table->integer("source_id")->nullable();
            $table->string("source_type")->nullable();
            $table->integer("list_id")->nullable();
            $table->integer("active")->nullable();
            $table->integer("showcase")->nullable();
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
        Schema::drop('files_relations');
    }
}
