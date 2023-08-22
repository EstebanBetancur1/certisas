<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSectionalsTable.
 */
class CreateSectionalsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sectionals', function(Blueprint $table) {
            $table->increments('id');

            $table->string('code');
            $table->string('title');

            // 1: Activo, 0: Inactivo
            $table->smallInteger('status')->default(1);

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
		Schema::drop('sectionals');
	}
}
