<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationToApplications extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('applications', function(Blueprint $table)
		{
			$table->integer('client_reps_id')->unsigned()->after('status_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('applications', function(Blueprint $table)
		{
			$table->dropColumn('client_reps_id');
		});
	}
}
