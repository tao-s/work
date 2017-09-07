<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAgentInquiryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_inquiries', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('sex');
            $table->dropColumn('birthday');
            $table->dropColumn('email');
            $table->dropColumn('phone');
            $table->dropColumn('school_record_id');
            $table->dropColumn('school_name');
            $table->dropColumn('graduate_year');
            $table->dropColumn('prefecture');
            $table->dropColumn('job_record');

            $table->integer('customer_id')->unsigned()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agent_inquiries', function (Blueprint $table) {
            $table->string('username')->after('id');
            $table->boolean('sex')->after('username');
            $table->date('birthday')->after('sex');
            $table->string('email')->after('birthday');
            $table->string('phone')->after('email');
            $table->integer('school_record_id')->unsigned()->nullable()->default(null)->after('phone');
            $table->string('school_name')->nullable()->default('')->after('school_record_id');
            $table->integer('graduate_year')->nullable()->default(null)->after('school_name');
            $table->integer('prefecture')->after('graduate_year');
            $table->text('job_record')->after('prefecture');

            $table->dropColumn('customer_id');
        });
    }

}
