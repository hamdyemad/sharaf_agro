<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersUnderWorkViewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_under_work_viewers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_under_work_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('viewed');
            $table->unique(['order_under_work_id', 'user_id']);
            $table->foreign('order_under_work_id')->references('id')->on('orders_under_work')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('orders_under_work_viewers');
    }
}
