<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('currency_id');
            $table->double('price');
            $table->double('discount')->nullable();
            $table->double('price_after_discount');
            $table->unique(['product_id', 'currency_id']);
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('currency_id')->on('currencies')->references('id')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_prices');
    }
}
