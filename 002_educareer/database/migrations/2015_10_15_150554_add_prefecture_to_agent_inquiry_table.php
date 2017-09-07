<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrefectureToAgentInquiryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agent_inquiries', function(Blueprint $table)
		{
			$table->string('prefecture')->nullable()->after('phone');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agent_inquiries', function(Blueprint $table)
		{
			$table->dropColumn('prefecture');
		});
	}

}
