<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSchoolInfoToAgentInquiryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agent_inquiries', function(Blueprint $table)
		{
			$table->integer('school_record_id')->unsigned()->nullable()->default(null)->after('phone');
			$table->string('school_name')->nullable()->default('')->after('school_record_id');
			$table->integer('graduate_year')->nullable()->default(null)->after('school_name');
			$table->dropColumn('school_record');
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
			$table->text('school_record')->after('phone');
			$table->dropColumn('school_record_id');
			$table->dropColumn('school_name');
			$table->dropColumn('graduate_year');
		});
	}

}
