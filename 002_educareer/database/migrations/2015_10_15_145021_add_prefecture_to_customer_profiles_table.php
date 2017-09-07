<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefectureToCustomerProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_profiles', function(Blueprint $table)
		{
			$table->string('prefecture')->nullable()->after('birthday');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customer_profiles', function(Blueprint $table)
		{
			$table->dropColumn('prefecture');
		});
	}

}
