<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_view', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('viewed');
            $table->unique(['new_id', 'user_id']);
            $table->foreign('new_id')->references('id')->on('news')->onDelete('cascade');
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
        Schema::dropIfExists('news_view');
    }
}
