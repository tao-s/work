<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {

            /**
             * 共通のプロパティ
             **/
            // うち外部キー等
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('job_category_id')->unsigned();
            $table->integer('employment_status_id')->unsigned();
            $table->integer('business_type_id')->unsigned();
            // うち募集要項
            $table->string('title');
            $table->string('job_title')->nullable()->default(null);;
            $table->text('main_message')->nullable()->default(null);;
            $table->text('work_place')->nullable()->default(null);;
            $table->string('main_image')->nullable()->default(null);
            $table->string('side_image1')->nullable()->default(null);
            $table->string('side_image1_caption')->nullable()->default(null);
            $table->string('side_image2')->nullable()->default(null);
            $table->string('side_image2_caption')->nullable()->default(null);
            $table->string('side_image3')->nullable()->default(null);
            $table->string('side_image3_caption')->nullable()->default(null);
            // うち企業概要
            $table->text('company_description')->nullable()->default(null);;
            $table->text('company_business')->nullable()->default(null);;
            $table->text('company_characteristics')->nullable()->default(null);;

            /**
             * 通常求人のみのプロパティ
             **/
            // うち募集要項
            $table->text('job_description');
            $table->text('background')->nullable()->default(null);
            $table->text('qualification')->nullable()->default(null);
            $table->string('prefecture');
            $table->text('work_hour')->nullable()->default(null);
            $table->text('salary')->nullable()->default(null);
            $table->text('benefit')->nullable()->default(null);
            $table->text('holiday')->nullable()->default(null);

            /**
             * フランチャイズ求人のみのプロパティ
             **/
            // うち募集要項
            $table->text('fr_about_product')->nullable()->default(null);
            $table->text('fr_about_market')->nullable()->default(null);
            $table->text('fr_pre_support')->nullable()->default(null);
            $table->text('fr_post_support')->nullable()->default(null);
            $table->text('fr_flow_to_open')->nullable()->default(null);
            $table->text('fr_business_model')->nullable()->default(null);
            $table->text('fr_contract_type')->nullable()->default(null);
            $table->text('fr_contract_period')->nullable()->default(null);
            $table->text('fr_initial_fund_amount')->nullable()->default(null);
            $table->text('fr_royalty')->nullable()->default(null);
            $table->text('fr_seminar_info')->nullable()->default(null);

            /**
             * 共通のフラグ系プロパティ
             **/
            $table->boolean('is_franchise');
            $table->boolean('can_publish')->default(false);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
        DB::statement('ALTER TABLE jobs ROW_FORMAT=DYNAMIC;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }

}
