<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryLangsTablosunaUrlVeArticleUrlAlanlariEklendi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * link_type ID'leri
     * 1 = Bağlantı yok (Default)
     * 2 = Elle Bağlantı oluştur.
     * 3 = Yazılardan Seç
     */
    public function up()
    {
        Schema::table('category_langs', function($table){
            $table->string('url')->nullable()->index();
            $table->string('article_url')->nullable();
            $table->integer('link_type')->default(1)->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_langs', function($table) {
            $table->dropColumn('url');
            $table->dropColumn('article_url');
            $table->dropColumn('link_type');
        });
    }
}
