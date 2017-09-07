<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentInquiriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_inquiries', function (Blueprint $table) {
            $table->increments('id');
			$table->string('username');
            $table->boolean('sex');
            $table->date('birthday');
            $table->string('email');
            $table->string('phone');
            $table->text('school_record');
            $table->text('job_record');
            $table->text('inquiry');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agent_inquiries');
    }

}
