<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminConfirmationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('admin_confirmations', function(Blueprint $table)
        {
            $table->increments('id');
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
        Schema::drop('admin_confirmations');
    }

}
