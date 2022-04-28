<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiresViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquires_view', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquire_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('viewed');
            $table->unique(['inquire_id', 'user_id']);
            $table->foreign('inquire_id')->references('id')->on('inquiries')->onDelete('cascade');
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
        Schema::dropIfExists('inquires_view');
    }
}
