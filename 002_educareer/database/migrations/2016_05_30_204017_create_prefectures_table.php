<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrefecturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prefectures', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('formal_title');
			$table->string('casual_title');
			$table->string('slug');
			$table->integer('sort');
			$table->integer('area_id')->unsigned()->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prefectures');
	}

}
