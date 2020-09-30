<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('Название');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('users');
            $table->integer('manager_id')->unsigned();
            $table->foreign('manager_id')->references('id')->on('users');
            $table->integer('order_id')->unsigned()->nullable(true);
            $table->foreign('order_id')->references('id')->on('orders');
            $table->bigInteger('parcel_id')->unsigned()->nullable(true);
            $table->foreign('parcel_id')->references('id')->on('parcels');
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
        Schema::dropIfExists('supports');
    }
}
