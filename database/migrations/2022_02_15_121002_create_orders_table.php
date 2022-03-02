<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('type', ['inhouse', 'online']);
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('notes')->nullable();
            $table->double('total_discount')->nullable();
            $table->double('shipping')->nullable();
            $table->double('grand_total');
            $table->boolean('viewed')->default(0);
            $table->boolean('client_viewed')->default(0);
            $table->boolean('client_status_viewed')->default(0);
            $table->foreign('city_id')->on('cities')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->on('statuses')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('branch_id')->on('branches')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('orders');
    }
}
