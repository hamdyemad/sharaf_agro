<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->string('variant')->nullable();
            $table->enum('variant_type', ['extra', 'size'])->nullable();
            $table->double('price')->nullable();
            $table->integer('qty');
            $table->double('total_price')->nullable();
            $table->foreign('order_id')->on('orders')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('orders_details');
    }
}
