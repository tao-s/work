<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpgradesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('upgrades', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('client_id')->unsigned();
			$table->integer('plan_id')->unsigned();
			$table->string('company_name');
			$table->string('ceo');
			$table->string('post_code');
			$table->string('address');
			$table->boolean('is_approved')->default(false);
			$table->date('expire_date')->nullable()->default(null);
			$table->softDeletes();
			$table->timestamps();

			$table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
			$table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('upgrades');
	}

}