<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminIdToAdminConfirmationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('admin_confirmations', function(Blueprint $table)
		{
			$table->integer('admin_id')->unsigned()->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('admin_confirmations', function(Blueprint $table)
		{
			$table->dropColumn('admin_id');
		});
	}

}
