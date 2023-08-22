<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCompanyActivitiesTable.
 */
class CreateCompanyActivitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_activities', function(Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedInteger('activity_id');
			$table->foreign('activity_id')->references('id')->on('activities');

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
		Schema::drop('company_activities');
	}
}
