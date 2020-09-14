<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('title')->comment('Заголовок');
            $table->string('address')->comment('Адрес');
            $table->string('phone')->comment('Телефоны');
            $table->string('email')->comment('E-mail');
            $table->string('description')->comment('Описание');
            $table->boolean('isPrivate')->default(false)->comment('Доступ при авторизации');
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
        Schema::dropIfExists('contacts');
    }
}
