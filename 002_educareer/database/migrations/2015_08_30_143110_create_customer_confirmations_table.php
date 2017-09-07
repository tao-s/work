<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerConfirmationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_confirmations', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('customer_id')->unsigned();
			$table->string('confirmation_token')->unique();
			$table->dateTime('token_generated_at');
			$table->dateTime('confirmed_at')->nullable()->default(null);
			$table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_confirmations');
	}

}
