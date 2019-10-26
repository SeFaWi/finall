<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('gender');
            $table->text('image')->nullable();
            $table->unsignedBigInteger('cities_id');
            $table->integer('is_a_company')->default('0');
            $table->integer('Status')->default('1');
            $table->integer('phone');
            $table->timestamps();
            $table->rememberToken();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('cities_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
