<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateCompanyResponsibilitiesTable.
 */
class CreateCompanyResponsibilitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('company_responsibilities', function(Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('company_id');
			$table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedInteger('responsibility_id');
			$table->foreign('responsibility_id')->references('id')->on('responsibilities');

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
		Schema::drop('company_responsibilities');
	}
}
