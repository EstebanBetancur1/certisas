<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEntitiesTable.
 */
class CreateEntitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('entities', function(Blueprint $table) {
            $table->increments('id');

            $table->string('nit')->nullable();
            $table->string('name')->nullable();

            $table->unsignedInteger('city_id')->nullable();
			$table->foreign('city_id')->references('id')->on('cities');

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
		Schema::drop('entities');
	}
}
