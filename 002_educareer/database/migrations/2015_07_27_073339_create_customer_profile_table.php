<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_profiles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->string('username')->nullable()->default(null);
			$table->boolean('sex')->nullable()->default(null);
            $table->date('birthday')->nullable()->default(null);
            $table->text('introduction')->nullable()->default(null);
            $table->text('future_plan')->nullable()->default(null);
            $table->text('school_record')->nullable()->default(null);
            $table->text('job_record')->nullable()->default(null);
            $table->text('skill')->nullable()->default(null);
            $table->text('qualification')->nullable()->default(null);
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
        Schema::drop('customer_profiles');
	}

}

