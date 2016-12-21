<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShoppingCartTablosunuOlustur extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cart', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('cart_id')->index();
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->integer('quantity')->unsigned()->nullable();
            $table->integer('is_available')->nullable()->default(1);
            $table->integer('customer_id')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('vat_included')->nullable();
            $table->decimal('price', 5, 2);
            $table->decimal('discounted_price', 5, 2);
            $table->decimal('total_price', 5, 2);
            $table->decimal('total_discounted_price', 5, 2);
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
        Schema::drop('shopping_cart');
    }
}
