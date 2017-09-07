<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRepTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_reps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('phone');
            $table->string('name');
            $table->string('password');
            $table->integer('client_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();

            $table->unique('email');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client_reps');
    }

}
