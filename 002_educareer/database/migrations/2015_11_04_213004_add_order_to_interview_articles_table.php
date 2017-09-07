<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToInterviewArticlesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('interview_articles', function(Blueprint $table)
		{
			$table->tinyInteger('order', false, true)->nullable()->after('client_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('interview_articles', function(Blueprint $table)
		{
			$table->dropColumn('order');
		});
	}

}
