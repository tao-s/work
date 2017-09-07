<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyForNewApplication extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function(Blueprint $table)
        {
            $table->tinyInteger('agency_contract')->default(0)->unsigned()->after('plan_months');
            $table->tinyInteger('franchise')->default(0)->unsigned()->after('agency_contract');
            $table->tinyInteger('full_time')->default(0)->unsigned()->after('franchise');
            $table->integer('price')->default(0)->unsigned()->after('full_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function(Blueprint $table)
        {
            $table->dropColumn([
                'agency_contract',
                'franchise',
                'full_time',
                'price',
            ]);
        });

    }

}
