<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLanguagesTable.
 */
class CreateLanguagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('languages', function(Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('lang')->unique();

            // 0: Inactive, 1: Active
            $table->smallInteger('status');

            $table->smallInteger('main')->default(0);

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
		Schema::drop('languages');
	}
}
