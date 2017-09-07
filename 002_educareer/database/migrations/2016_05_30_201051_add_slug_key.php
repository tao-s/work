<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugKey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('job_categories', function(Blueprint $table)
		{
			$table->string('slug')->after('title');
			$table->string('description')->after('slug');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('job_categories', function(Blueprint $table)
		{
			$table->dropColumn('slug');
			$table->dropColumn('description');
		});
	}

}
