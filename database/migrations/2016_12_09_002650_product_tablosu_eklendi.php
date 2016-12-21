<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductTablosuEklendi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->default('0')->index();
            $table->string('name')->nullable();
            $table->text('desc')->nullable();
            $table->string('keywords')->nullable();
            $table->longText('content')->nullable();
            $table->integer('brand_id')->nullable()->default('0');
            $table->decimal('price', 5, 2);
            $table->integer('discount')->nullable()->default('0');
            $table->integer('installment')->unsigned();
            $table->integer('vat_included')->unsigned();
            $table->integer('barcode')->nullable();
            $table->integer('quantity')->unsigned()->default('0');
            $table->integer('list_id')->unsigned()->default('0');
            $table->integer('active')->unsigned()->default('1');
            $table->string('quantity_type')->nullable();
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
        Schema::drop('products');
    }
}
