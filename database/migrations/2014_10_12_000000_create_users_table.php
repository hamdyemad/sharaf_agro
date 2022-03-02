<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('name');
            $table->enum('type', ['admin', 'user', 'sub-admin']);
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->unique();
            $table->text('avatar')->nullable();
            $table->boolean('banned')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreign('branch_id')->on('branches')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
