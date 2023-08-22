<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMunicipalitiesTable.
 */
class CreateMunicipalitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('municipalities', function(Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('state_id');
			$table->foreign('state_id')->references('id')->on('states');

            $table->string('code')->nullable();
            $table->string('name')->nullable();

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
		Schema::drop('municipalities');
	}
}
