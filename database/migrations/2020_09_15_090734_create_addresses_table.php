<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('firstname')->comment('Имя');
            $table->string('lastname')->comment('Фамилия');
            $table->string('othername')->comment('Отчество');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string('postal_code')->comment('Почтовый индекс');
            $table->string('region')->comment('Область/край/республика');
            $table->string('city')->comment('Город');
            $table->string('street')->comment('Улица');
            $table->string('building')->comment('№ здания');
            $table->string('body')->nullable(true)->comment('Корпус');
            $table->string('apartment')->nullable(true)->comment('Квартира');
            $table->string('phone')->comment('Телефон');
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
        Schema::dropIfExists('addresses');
    }
}
