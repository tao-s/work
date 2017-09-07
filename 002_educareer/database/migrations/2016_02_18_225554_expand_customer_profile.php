<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpandCustomerProfile extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('work_locations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
		});

		Schema::create('industry_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
		});

		Schema::create('customer_profile_industry_type', function(Blueprint $table)
		{
			$table->integer('customer_profile_id')->unsigned();
			$table->integer('industry_type_id')->unsigned();

			$table->foreign('customer_profile_id')->references('id')->on('customer_profiles');
			$table->foreign('industry_type_id')->references('id')->on('industry_types');
		});

		Schema::create('occupation_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
		});

		Schema::create('customer_profile_occupation_category', function(Blueprint $table)
		{
			$table->integer('customer_profile_id')->unsigned();
			$table->integer('occupation_category_id')->unsigned();
			$table->string('free_word');

			// MySQLの外部キー制約名の長さ制限（64文字）回避のため名前を指定している
			$table->foreign('customer_profile_id', 'cpoc_customer_profile_id_foreign')
				->references('id')->on('customer_profiles');
			$table->foreign('occupation_category_id', 'cpoc_occupation_category_id_foreign')
				->references('id')->on('occupation_categories');
		});

		Schema::table('customer_profiles', function(Blueprint $table)
		{
			$table->integer('work_location_id')->unsigned()->nullable()->after('scout_mail_flag');
			$table->string('company_name')->after('work_location_id');

			$table->foreign('work_location_id')->references('id')->on('work_locations');
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
			$table->dropForeign('customer_profiles_work_location_id_foreign');
			$table->dropColumn('work_location_id');
			$table->dropColumn('company_name');
		});
		Schema::drop('work_locations');
		Schema::drop('customer_profile_industry_type');
		Schema::drop('industry_types');
		Schema::drop('customer_profile_occupation_category');
		Schema::drop('occupation_categories');
	}

}
