<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRepConfirmationTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_rep_confirmations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_rep_id')->unsigned();
            $table->string('confirmation_token')->unique();
            $table->dateTime('token_generated_at');
            $table->dateTime('confirmed_at')->nullable()->default(null);
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
        Schema::drop('client_rep_confirmations');
    }

}
