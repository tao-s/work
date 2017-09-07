<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('applications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('job_id')->unsigned();
			$table->integer('customer_id')->unsigned();
			$table->integer('status_id')->unsigned()->default(1);

			$table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
			$table->foreign('status_id')->references('id')->on('application_statuses')->onDelete('cascade');
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
		Schema::drop('applications');
	}

}