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
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('manager_id')->unsigned();
            $table->foreign('manager_id')->references('id')->on('users');
            $table->string('title')->comment('Название');
            $table->integer('count')->comment('Количество');
            $table->string('link')->nullable(true)->comment('Ссылка');
            $table->float('price', 8, 2)->comment('Цена');
            $table->string('color')->nullable(true)->comment('Цвет');
            $table->string('size')->nullable(true)->comment('Размер');
            $table->text('description')->comment('Описание');
            $table->boolean('isDeleted')->default(false)->comment('Удаленено');
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
