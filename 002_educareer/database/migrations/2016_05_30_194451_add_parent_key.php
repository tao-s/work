<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParentKey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('business_types', function(Blueprint $table)
		{
			$table->string('slug')->after('title');
			$table->integer('grand_business_type_id')->unsigned()->default(1)->after('slug');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('business_types', function(Blueprint $table)
		{
			$table->dropColumn('slug');
			$table->dropColumn('grand_business_type_id');
		});
	}

}
