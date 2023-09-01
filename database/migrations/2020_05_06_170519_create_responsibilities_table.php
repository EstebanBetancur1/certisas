<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateResponsibilitiesTable.
 */
class CreateResponsibilitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('responsibilities', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('code');
            $table->string('title');

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
		Schema::drop('responsibilities');
	}
}
