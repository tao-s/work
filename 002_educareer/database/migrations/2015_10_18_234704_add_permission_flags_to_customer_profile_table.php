<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissionFlagsToCustomerProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_profiles', function(Blueprint $table)
		{
			$table->boolean('mail_magazine_flag')->default(false)->after('qualification');
			$table->boolean('scout_mail_flag')->default(false)->after('mail_magazine_flag');
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
			$table->dropColumn('mail_magazine_flag');
			$table->dropColumn('scout_mail_flag');
		});
	}

}
