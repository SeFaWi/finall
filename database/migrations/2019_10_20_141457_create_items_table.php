<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('Status')->default('1');
            $table->text('description');
            $table->integer('available')->default('1');
            $table->unsignedBigInteger('categorie_id');
            $table->integer('delivery')->default('0');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('user_id');
            $table->text('address');
            $table->timestamps();
        });
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');});
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });Schema::table('items', function (Blueprint $table) {
        $table->foreign('categorie_id')
            ->references('id')
            ->on('categories')
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
        Schema::dropIfExists('items');
    }
}
